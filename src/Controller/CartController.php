<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig');
    }
    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add($id): Response 
    {
        dd($id);
        return $this->render('cart/index.html.twig');
    }

}

