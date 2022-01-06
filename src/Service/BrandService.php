<?php

namespace App\Service;

use App\Entity\Brand;
use Exception;

class BrandService
{
	/**
	 * Get the shipping fees for a brand
	 * 
	 * @param Brand $brand
	 * @param int $nbItem
	 * 
	 * @return float 
	 **/
	public function getShippingFees(Brand $brand, int $nbItem = null): float 
	{
		// Default shipping fees
		$shippingFees = 5.0;

		// Rule : +20€ every three products (1,2,3 = 20€ | 4,5,6 = 40...)
		if ($brand->getSlug() === "farmitoo") {
			if (is_null($nbItem)) {
				throw new Exception("At least one item is needed to calculate Farmitoo shipping fees");
			}

            $shippingFees = ceil(($nbItem / 3)) * 20;
        }

		// Rule : +15€ 
        if ($brand->getSlug() === "gallagher") {
            $shippingFees = 15;
        }

        return $shippingFees;
	}
}