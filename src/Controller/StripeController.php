<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{reference} ', name: 'app_stripe_create_session')]
    public function index(Cart $cart, $reference): Response
    {  
        
        $products_for_stripe =[];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        foreach($cart->getFull() as $produit){

            $products_for_stripe[] = [
                'price_data' =>[
                    'currency' => 'eur',
                    'unit_amount' => $produit ['produit']->getPrice(),
                    'product_data' => [
                        'name' => $produit['produit'] ->getName(),
                        'images'=>[$YOUR_DOMAIN."/img/".$produit['produit'] ->getIllustration()],
                    ],
                ],
                'quantity' => $produit ['quantity'],

            ];
            


        }

       
        $stripeSecretKey = 'sk_test_51McRryAfx61CvZPsIHsiBqrOENX3UrMQa92CKNKD8erxfl5oUkkCuGC3MP1uEV34Crm9JpM0FZNxvqn3PsH3nwow007aG0XnB2';
        Stripe::setApiKey($stripeSecretKey);

         

          
            $checkout_session = Session::create([

                'payment_method_types' => ['card'],
              'line_items' => [$products_for_stripe
            ],
              'mode' => 'payment',
              'success_url' => $YOUR_DOMAIN . '/success.html',
              'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            ]);

            $response = new JsonResponse(['id' =>$checkout_session->id]);
            return $response ;
    }
}
