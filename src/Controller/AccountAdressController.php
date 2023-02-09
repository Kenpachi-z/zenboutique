<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AdressType;
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
        $adress = new Adress();
        $form = $this->createForm(AdressType::class, $adress);
        //dd($this->getUser());
        return $this->render('account/adress_add.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
