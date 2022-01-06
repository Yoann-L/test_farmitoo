<?php

namespace App\Tests\Unit\Service;

use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\PromotionHistory;
use App\Entity\Item;
use App\Entity\Brand;
use App\Entity\Cart;
use App\Service\ItemService;
use App\Service\ProductService;
use App\Service\BrandService;
use App\Service\PromotionService;
use App\Service\CartService;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Exception;
use DateTimeImmutable;

class CartServiceTest extends KernelTestCase
{
    private $entityManager;

    private $productService;

    private $brandService;

    private $itemService;

    private $promotionService;

    private $cartService;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->productService = New ProductService();
        $this->brandService = New BrandService();
        $this->itemService = New ItemService($this->productService);
        $this->promotionService = New PromotionService();

        $this->cartService = New cartService($this->entityManager, $this->productService, $this->brandService, $this->itemService, $this->promotionService);
    }

    public function testGenerateCartItemsSummary()
    {
        $cart = $this->createCart();

        $expectedResult = [
            [
                "title" => "Cuve à gasoil",
                "quantity" => 1,
                "price" => 250.0,
                "total_duty_free" => 250.0,
                "vat" => 20.0,
                "vat_amount" => 50.0,
                "total" => 300.0

            ],
            [
                "title" => "Nettoyant pour cuve",
                "quantity" => 3,
                "price" => 5.0,
                "total_duty_free" => 15.0,
                "vat" => 20.0,
                "vat_amount" => 3.0,
                "total" => 18.0

            ],
            [
                "title" => "Piquet de clôture",
                "quantity" => 5,
                "price" => 10.0,
                "total_duty_free" => 50.0,
                "vat" => 5.0,
                "vat_amount" => 2.5,
                "total" => 52.5

            ]
        ];

        $this->assertSame($expectedResult, $this->cartService->generateCartItemsSummary($cart));
    }

    public function testGenerateCartSubtotalSummary()
    {
        $cart = $this->createCart();

        $expectedResult = [
            "total_duty_free" => 315.0,
            "shipping_fees" => 15.0
        ];

        $this->assertSame($expectedResult, $this->cartService->generateCartSubtotalSummary($cart));
    }

    public function testGenerateCartSubtotalSummaryWithEmptyCart()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Cart is empty");

        $this->cartService->generateCartSubtotalSummary(New Cart());
    }

    public function testGenerateVatSumary()
    {
        $cart = $this->createCart();

        $expectedResult = [
            "detail_vat" => [
                20 => 53.0,
                5 => 2.5
            ],
            "total" => 55.5
        ];

        $this->assertSame($expectedResult, $this->cartService->generateVatSumary($cart));
    }

    public function testGenerateVatSumaryWithEmptyCart()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Cart is empty");

        $this->cartService->generateVatSumary(New Cart());
    }

    public function testGeneratePromotionSummary()
    {
        $cart = $this->createCart();

        $expectedResult = [
            "cart" => [
                "free_shipping_fees" => true,
                "discount_fix" => 10,
                "discount_percentage" => 20
            ]
        ];

        $this->assertSame($expectedResult, $this->cartService->generatePromotionSummary($cart));
    }

    public function testGeneratePromotionSummaryWithExpiredPromotion()
    {
        $promotion = New Promotion();
        $promotion->setStatus(Promotion::PROMOTION_ENABLE);
        $promotion->setExpiratedAt(New DateTimeImmutable("2021-12-24 23:59:59"));

        $promotionHistory = New PromotionHistory();
        $promotionHistory->setPromotion($promotion);

        $cart = New Cart();
        $cart->addPromotionHistory($promotionHistory);

        $this->assertSame([], $this->cartService->generatePromotionSummary($cart));
    }

    public function testGenerateCartSummary()
    {
        $cart = $this->createCart();

        $expectedResult = [
            "items" => [
                [
                    "title" => "Cuve à gasoil",
                    "quantity" => 1,
                    "price" => 250.0,
                    "total_duty_free" => 250.0,
                    "vat" => 20.0,
                    "vat_amount" => 50.0,
                    "total" => 300.0

                ],
                [
                    "title" => "Nettoyant pour cuve",
                    "quantity" => 3,
                    "price" => 5.0,
                    "total_duty_free" => 15.0,
                    "vat" => 20.0,
                    "vat_amount" => 3.0,
                    "total" => 18.0

                ],
                [
                    "title" => "Piquet de clôture",
                    "quantity" => 5,
                    "price" => 10.0,
                    "total_duty_free" => 50.0,
                    "vat" => 5.0,
                    "vat_amount" => 2.5,
                    "total" => 52.5

                ]
            ],
            "promotion" => [
                "cart" => [
                  "free_shipping_fees" => true,
                  "discount_fix" => 10,
                  "discount_percentage" => 20
                ],
                "total" => 110.0
            ],
            "subtotal" => [
                "total_duty_free" => 315.0,
                "shipping_fees" => 15.0
            ],
            "vat" => [
                "detail_vat" => [
                    20 => 53.0,
                    5 => 2.5
                ],
                "total" => 55.5
            ],
            "total" => 385.5,
            "total_with_promotion" => 260.5
        ];

        $this->createCart();

        $this->assertSame($expectedResult, $this->cartService->generateCartSummary($cart));
    }

    private function createCart(): Cart
    {
        $promotion = New Promotion();
        $promotion->setStatus(Promotion::PROMOTION_ENABLE);
        $promotion->setExpiratedAt(New DateTimeImmutable("2030-12-24 23:59:59"));
        $promotion->setFreeShippingFees(true);
        $promotion->setDiscountFix(10);
        $promotion->setDiscountPercentage(20);
        $promotion->setType(Promotion::PROMOTION_TYPE_CART);

        $promotionHistory = New PromotionHistory();
        $promotionHistory->setPromotion($promotion);

        $cart = New Cart();
        $cart->addPromotionHistory($promotionHistory);

        $brand1 = New Brand;
        $brand1->setName("Farmitoo");
        $brand1->setSlug("farmitoo");
        $brand1->setStatus(Brand::BRAND_ENABLE);
        $brand1->setVat(20);

        $brand2 = New Brand;
        $brand2->setName("Gallagher");
        $brand2->setSlug("gallagher");
        $brand2->setStatus(Brand::BRAND_ENABLE);
        $brand2->setVat(5);

        $productsInfos = [
            [
                "brand" => $brand1,
                "title" => "Cuve à gasoil",
                "price" => 250,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "ABCD1234"
            ],
            [
                "brand" => $brand1,
                "title" => "Nettoyant pour cuve",
                "price" => 5,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "253974EK"
            ],
            [
                "brand" => $brand2,
                "title" => "Piquet de clôture",
                "price" => 10,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "542424AZ"
            ]
        ];

        foreach ($productsInfos as $productInfos) {
            $product = new Product();
            $product->setBrand($productInfos["brand"]);
            $product->setTitle($productInfos["title"]);
            $product->setPrice($productInfos["price"]);
            $product->setStatus($productInfos["status"]);
            $product->setReference($productInfos["reference"]);

            $productList[] = $product;
        }

        $itemsInfos = [
            [
                "product" => $productList[0],
                "cart" => $cart,
                "quantity" => 1
            ],
            [
                "product" => $productList[1],
                "cart" => $cart,
                "quantity" => 3
            ],
            [
                "product" => $productList[2],
                "cart" => $cart,
                "quantity" => 5
            ]
        ];

        foreach ($itemsInfos as $itemInfos) {
            $item = new Item();
            $item->setProduct($itemInfos["product"]);
            $item->setCart($itemInfos["cart"]);
            $item->setQuantity($itemInfos["quantity"]);

            $cart->addItem($item);

            $itemList[] = $item;
        }

        return $cart;
    }
}