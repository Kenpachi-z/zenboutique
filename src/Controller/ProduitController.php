<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    private $entityManager ;
    public function __construct(EntityManagerInterface $entityManagerInterface)

    {


        $this->entityManager = $entityManagerInterface;
    }
    


    #[Route('/nos-produits', name: 'app_produit')] 
    public function index(): Response
    {
        $produit = $this->entityManager->getRepository(produit::class)->findAll();

        return $this->render('produit/index.html.twig',[
            'produit'=>$produit
        ] 
     );

    }
}
