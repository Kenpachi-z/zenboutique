<?php

namespace App\Controller;

use App\classe\Cart;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateTimeImmutable;
;
class OrderController extends AbstractController
{
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

           dd($delivery_content);
          $order= new Order();

          $order->setUser($this->getUser);
          $order->setCreatedAt($date);
          $order->setCarrierName($carriers->getName());
          $order->setCarrierPrice($carriers->getCarrierPrice());




        }
        
        return $this->render('order/add.html.twig',[
            
            'cart'=>$cart->getFull()
        ]);
    }
}
