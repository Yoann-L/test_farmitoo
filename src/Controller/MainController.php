<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Promotion;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="cart")
     */
    public function index(): Response
    {
        $product1 = new Product('Cuve à gasoil', 250000, 'Farmitoo');
        $product2 = new Product('Nettoyant pour cuve', 5000, 'Farmitoo');
        $product3 = new Product('Piquet de clôture', 1000, 'Gallagher');

        $promotion1 = new Promotion(50000, 8, false);

        // Je passe une commande avec
        // Cuve à gasoil x1
        // Nettoyant pour cuve x3
        // Piquet de clôture x5

        $cart["items"] = [
            [
                "title" => "Cuve à gasoil",
                "amount" => 1,
                "price" => 250.00,
                "vat" => 20,
            ],
            [
                "title" => "Nettoyant pour cuve",
                "amount" => 3,
                "price" => 50.00,
                "vat" => 10,
            ],
            [
                "title" => "Piquet de clôture",
                "amount" => 5,
                "price" => 10.00,
                "vat" => 10,
            ]
        ];

        $cart["subtotal"]["total_duty_free"] = 0;
        foreach ($cart["items"] as $item) {
            $cart["subtotal"]["total_duty_free"] += $item["amount"] * $item["price"];

            if (!isset($cart["subtotal"]["vat"][$item["vat"]])) {
                $cart["subtotal"]["vat"][$item["vat"]] = $item["vat"] * ($item["amount"] * $item["price"]) / 100;
            } else {
                $cart["subtotal"]["vat"][$item["vat"]] += $item["vat"] * ($item["amount"] * $item["price"]) / 100;
            }
        }

        $cart["subtotal"]["shipping_fees"] = 5.00;
        $cart["subtotal"]["promotion"] = 10.00;

        $vatAmount = 0;
        foreach ($cart["subtotal"]["vat"] as $key => $value) {
            $vatAmount += $value;
        }


        $cart["total"] = $cart["subtotal"]["total_duty_free"] + $vatAmount + $cart["subtotal"]["shipping_fees"] - $cart["subtotal"]["promotion"];

        return $this->render('cart.html.twig', [
            'cart' => $cart
        ]);
    }
}
