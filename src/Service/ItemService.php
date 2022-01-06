<?php

namespace App\Service;

use App\Entity\Item;

class ItemService
{
	private $productService;

	public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

	/**
	 * Calculate the VAT amount for a quantity of an item
	 * 
	 * @param Item $item
	 * 
	 * @return float
	 * 
	 **/
	public function calculVatAmount(Item $item): float 
	{
		return ($this->productService->getVat($item->getProduct()) * ($item->getQuantity() * $item->getProduct()->getPrice())) / 100;
	}
}