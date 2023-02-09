<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{
    #[Route('/compte/adresses', name: 'app_account_adress')]
    public function index(): Response
    {
        //dd($this->getUser());
        return $this->render('account/adress.html.twig');
   
    }

    #[Route('/compte/ajouter-une-adresse', name: 'app_account_adress_add')]
    public function add(): Response
    {
        //dd($this->getUser());
        return $this->render('account/adress_add.html.twig');
    }
}
