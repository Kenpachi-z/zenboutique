<?php

namespace App\Controller;

use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'app_order')]
    public function index(): Response
    {
        $form =$this->createForm(OrderType::class);
        
        return $this->render('order/index.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
