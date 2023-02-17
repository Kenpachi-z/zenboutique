<?php

namespace App\Controller;


use App\classe\Cart;
use App\Entity\Order;
use App\Entity\orderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }


    #[Route('/commande', name: 'app_order')]
    public function index(Cart $cart, Request $request): Response
    {
         if(!$this->getUser()->getAdresses()->getValues())
         {
            return $this->redirectToRoute('app_account_adress_add');
         }

        $form =$this->createForm(OrderType::class, null, [
            'user'=> $this->getUser()
        ]);
            $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            


        }
       
        return $this->render('order/index.html.twig',[
            'form'=>$form->createView(),
            'cart'=>$cart->getFull()
        ]);
    }

     #[Route('/commande/recapitulatif', name: 'app_order_recap', methods:("POST"))]
    public function add(Cart $cart, Request $request): Response
    {
        

        $form =$this->createForm(OrderType::class, null, [
            'user'=> $this->getUser()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $date = new \DateTimeImmutable();
           $carriers = $form->get('carriers')->getData();
           $delivery = $form->get('adresses')->getData();
           $delivery_content = $delivery->getFirstname() .''.$delivery->getLastname();
           $delivery_content.= '<br/>'.$delivery->getPhone();

           if($delivery->getCompagny())
           {
            $delivery_content.= '<br/>'.$delivery->getCompagny();
            
         }
           
         $delivery_content.= '<br/>'.$delivery->getAdress();
         $delivery_content.= '<br/>'.$delivery->getPostal().''.$delivery->getCity();$delivery_content.= '<br/>'.$delivery->getCountry();

           // Enregistrer ma commande order ()
          $order= new Order();

          $order->setUser($this->getUser());
          $order->setCreatedAt($date);
          $order->setCarrierName($carriers->getName());
          $order->setCarrierPrice($carriers->getPrice());
          $order->setDelivery($delivery_content);
          $order->setIspaid(0);
          
          $this->entityManager->persist($order);

          $products_for_stripe =[];
          $YOUR_DOMAIN = 'http://127.0.0.1:8000';

         //Enregistrer mes produits orderDetails()

          foreach($cart->getFull() as $produit) {
           $orderDetails = new OrderDetails();

            $orderDetails->setMyOrder($order);
            $orderDetails->setProduit($produit['produit'] ->getName());
            $orderDetails->setQuantity($produit ['quantity']);
            $orderDetails->setPrice($produit ['quantity']);
            $orderDetails->setQuantity($produit ['produit']->getPrice());
            $orderDetails->setTotal($produit ['produit']->getPrice() * $produit ['quantity']);
            $this->entityManager->persist($orderDetails);

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
      
            //$this->entityManager->flush();
        
// Keep your Stripe API key protected by including it as an environment variable
// or in a private script that does not publicly expose the source code.

// This is your test secret API key.
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
dump($checkout_session->id);
dd($checkout_session);



          return $this->render('order/add.html.twig',[
           
            'cart'=>$cart->getFull(),
            'carrier' => $carriers,
            'delivery' => $delivery_content
        ]);
           }
           
           return $this->redirectToRoute('app_cart');
        } 
        
       

    
}
