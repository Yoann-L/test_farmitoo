<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\CartService;
use Exception;

class MainController extends AbstractController
{
    /**
     * @Route("/{reference}", name="cart", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, CartService $cartService, string $reference = null): Response
    {
        $errorMessage = null;
        $summary = [];
        $cart = null;

        if (!is_null($reference)) {
            $cart = $cartService->findCart($reference);
        }

        if (is_null($cart)) {
            $errorMessage = "Cart not found";
        } else {
            try {
                $summary = $cartService->generateCartSummary($cart);
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
            }
        }

        return $this->render("cart.html.twig", [
            'summary' => $summary,
            'errorMessage' => $errorMessage
        ]);
    }
}
