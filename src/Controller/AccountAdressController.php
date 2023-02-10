<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager = $entityManager;
    }


    #[Route('/compte/adresses', name: 'app_account_adress')]
    public function index(): Response
    {
        //dd($this->getUser());
        return $this->render('account/adress.html.twig');
   
    }

    #[Route('/compte/ajouter-une-adresse', name: 'app_account_adress_add')]
    public function add(Request $request): Response
    {
        $adress = new Adress();

        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $adress->setUser($this->getUser());
            $this->entityManager->persist($adress);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_adress');

            
        }
        return $this->render('account/adress_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    #[Route('/compte/modifier-une-adresse/{id}', name: 'app_account_adress_edit')]
    public function edit(Request $request, $id): Response
    {
        $adress = $this->entityManager->getRepository( adress::class)->findOneById($id);

        if(!$adress|| $adress->getUser()!= $this->getUser()) {
            return $this->redirectToRoute('app_account_adress');
        }

        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_adress');

            
        }
        return $this->render('account/adress_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/compte/supprimer-une-adresse/{id}', name: 'app_account_adress_delete')]
    public function delete($id): Response
    {
        $adress = $this->entityManager->getRepository( adress::class)->findOneById($id);

        if($adress && $adress->getUser() == $this->getUser()) {
            
            $this->entityManager->remove($adress);
            $this->entityManager->flush();
        }
        

            return $this->redirectToRoute('app_account_adress');

            
        }
        
    }

