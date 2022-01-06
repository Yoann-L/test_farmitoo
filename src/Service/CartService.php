<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cart;
use App\Entity\Promotion;
use Exception;

class CartService
{
	private $entityManager;

	private $productService;

	private $brandService;

	private $itemService;

	private $promotionService;

    public function __construct(EntityManagerInterface $entityManager, ProductService $productService, BrandService $brandService, ItemService $itemService, PromotionService $promotionService)
    {
        $this->entityManager = $entityManager;
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->itemService = $itemService;
        $this->promotionService = $promotionService;
    }

	/**
	 * Find a cart by reference
	 * 
	 * @param string $reference
	 * 
	 * @return Cart|null
	 **/
	public function findCart(string $reference): ?Cart 
	{
		$cartRepository = $this->entityManager->getRepository(Cart::class);

        return $cartRepository->findOneBy(["reference" => $reference]);
	}

	/**
	 * Generate the items summary for a cart
	 * 
	 * @param Cart $cart
	 * 
	 * @return array
	 **/
	public function generateCartItemsSummary(Cart $cart): array 
	{
		$result = [];

		foreach ($cart->getItems() as $item) {
			$totalDutyFree = $item->getQuantity() * $item->getProduct()->getPrice();
			$vat = $this->productService->getVat($item->getProduct());
			$vatAmount = ($totalDutyFree * $vat) / 100;

			$result[] = [
	            "title" => $item->getProduct()->getTitle(),
	            "quantity" => $item->getQuantity(),
	            "price" => $item->getProduct()->getPrice(),
	            "total_duty_free" => $totalDutyFree,
	            "vat" => $vat,
	            "vat_amount" => $vatAmount,
	            "total" => $totalDutyFree + $vatAmount
	        ];
		}

		return $result;
	}

	/**
	 * Generate the subtotal summary for a Cart
	 * 
	 * @param Cart $cart
	 * 
	 * @return array
	 **/
	public function generateCartSubtotalSummary(Cart $cart): array 
	{
		if ($cart->getItems()->isEmpty()) {
			throw new Exception("Cart is empty");
		}

		$result = [];

		$result["total_duty_free"] = 0;
		$nbItemsByBrand = [];

		foreach ($cart->getItems() as $item) {
			$product = $item->getProduct();
			$brandId = $product->getBrand()->getId();

			/* Calculate the duty free */
			$result["total_duty_free"] += $item->getQuantity() * $product->getPrice();

            /* Calculate nb product by brand, that will be useful for calculate the shipping fees by brand */
            $nbItemsByBrand[$brandId]["brand"] = $product->getBrand();

			// If it's the first product in the cart with this brand, create the key
            if (!isset($nbItemsByBrand[$brandId]["quantity"])) {
                $nbItemsByBrand[$brandId]["quantity"] = $item->getQuantity();
            } else {
                $nbItemsByBrand[$brandId]["quantity"] += $item->getQuantity();
            }
		}

		/* Calculate the shipping fees */
		$result["shipping_fees"] = 0;
        foreach ($nbItemsByBrand as $itemsByBrandInfos) {
        	// Check the shipping fees rules by brand, increase shipping fees by brands
        	$result["shipping_fees"] += $this->brandService->getShippingFees($itemsByBrandInfos["brand"], $itemsByBrandInfos["quantity"]);
        }

		return $result;
	}

	/**
	 * Generate the VAT summary for a Cart
	 * 
	 * @param Cart $cart
	 * 
	 * @return array
	 **/
	public function generateVatSumary(Cart $cart): array 
	{
		if ($cart->getItems()->isEmpty()) {
			throw new Exception("Cart is empty");
		}

		$result = [];

		foreach ($cart->getItems() as $item) {
			$product = $item->getProduct();
			$productVat = $this->productService->getVat($product);

			// If it's the first product in the cart with this VAT, create the key
			if (!isset($result["detail_vat"][$productVat])) {
                $result["detail_vat"][$productVat] = $this->itemService->calculVatAmount($item);
            } else {
                $result["detail_vat"][$productVat] += $this->itemService->calculVatAmount($item);
            }
		}

		$result["total"] = 0;
        foreach ($result["detail_vat"] as $vat => $value) {
            $result["total"] += $value;
        }

		return $result;
	}

	/**
	 * Generate the promotion summary for a cart
	 * 
	 * @param Cart $cart
	 * 
	 * @return array 
	 **/
	public function generatePromotionSummary(Cart $cart): array 
	{
		$result = [];

		foreach ($cart->getPromotionHistories() as $promotionHistory) {
			$promotion = $promotionHistory->getPromotion();

			if (!$this->promotionService->isActive($promotion)) {
				continue;
			}

			if ($promotion->getType() === Promotion::PROMOTION_TYPE_CART) {
				if ($promotion->getFreeShippingFees()) {
					$result[strtolower($promotion->getType())]["free_shipping_fees"] = $promotion->getFreeShippingFees();
				}

				if ($promotion->getDiscountFix()) {
					$result[strtolower($promotion->getType())]["discount_fix"] = $promotion->getDiscountFix();
				}

				if ($promotion->getDiscountPercentage()) {
					$result[strtolower($promotion->getType())]["discount_percentage"] = $promotion->getDiscountPercentage();
				}
			} else if ($promotion->getType() === Promotion::PROMOTION_TYPE_PRODUCT)	{
				// Add rules for a product promotion
				// ...
			}		
		}

		return $result;
	}

	/**
	 * Generate the all cart summary
	 * 
	 * @param Cart $cart
	 * 
	 * @return array
	 **/
	public function generateCartSummary(Cart $cart): array 
	{
		$result["items"] = $this->generateCartItemsSummary($cart);
		$result["promotion"] = $this->generatePromotionSummary($cart);
		$result["subtotal"] = $this->generateCartSubtotalSummary($cart);
		$result["vat"] = $this->generateVatSumary($cart);

		$result["total"] = $result["subtotal"]["total_duty_free"] + $result["vat"]["total"] + $result["subtotal"]["shipping_fees"];
		$result["total_with_promotion"] = $result["total"];

		$result["promotion"]["total"] = 0;

		// Apply cart promotions 
		if (isset($result["promotion"]["cart"])) {
			if (isset($result["promotion"]["cart"]["free_shipping_fees"]) && $result["promotion"]["cart"]["free_shipping_fees"] === true) {
				$result["total_with_promotion"] -= $result["subtotal"]["shipping_fees"];
			}

			if (isset($result["promotion"]["cart"]["discount_fix"])) {
				$result["total_with_promotion"] -= $result["promotion"]["cart"]["discount_fix"];
				$result["promotion"]["total"] += $result["promotion"]["cart"]["discount_fix"];
			}

			if (isset($result["promotion"]["cart"]["discount_percentage"])) {
				$promotionValue = round(($result["total"] * $result["promotion"]["cart"]["discount_percentage"]) / 100, -2);
				$result["total_with_promotion"] -= $promotionValue;
				$result["promotion"]["total"] += $promotionValue;
			}
		}

		// Apply products promotions 
		if (isset($result["promotion"]["product"])) {
			//...
		}

		return $result;
	}
}