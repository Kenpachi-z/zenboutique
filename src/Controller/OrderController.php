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
;
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

     #[Route('/commande/recapitulatif', name: 'app_order_recap')]
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
           $delivery_content = $delivery->getFirstname().''.$delivery->getLastname();
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
            //dd($produit);
          }


            $this->entityManager->flush();
        }
        
        return $this->render('order/add.html.twig',[
            
            'cart'=>$cart->getFull()
        ]);
    }
}
