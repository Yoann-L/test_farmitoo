<?php

namespace App\Service;

use App\Entity\Promotion;
use DateTime;

class PromotionService
{
	/**
	 * Check if a promotion is still valid
	 * 
	 * @param Promotion $promotion
	 * 
	 * @return bool
	 * 
	 **/
	public function isActive(Promotion $promotion): bool 
	{
		if ($promotion->getStatus() === Promotion::PROMOTION_DISABLE) {
			return false;
		}

		if ($promotion->getExpiratedAt() < new DateTime('NOW')) {
			return false;
		}

		return true;
	}

	/**
	 * Check if a promotion can be added to a cart 
	 * 
	 * @param Promotion $promotion
	 * @param Cart $cart
	 * 
	 * @return bool
	 * 
	 **/
	public function canBeAddedToCart(Promotion $promotion, Cart $cart): bool
	{
		// Add differents rules :
		//  - user can only use the promotion one time
		//  - minimum price of cart
		// ...

		return true;
	}
}