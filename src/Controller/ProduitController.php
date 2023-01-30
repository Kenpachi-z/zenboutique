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
    


    #[Route('/nos-produit', name: 'app_produit')] 
    public function index(): Response
    {
        $produit= $this->entityManager->getRepository(Produit::class)->findAll();

        return $this->render('produit/index.html.twig',[
            'produit'=>$produit
        ] 
     );

    }

    #[Route('/product/{Slug}', name: 'app_product')] 
    public function show($Slug): Response
    {

        $product = $this->entityManager->getRepository(Produit::class)->findOneBy(['Slug' => $Slug]);
        if(!$product){
            return $this->redirectToRoute('app_produit');
        }

        return $this->render('produit/show.html.twig',[
            'produit'=>$product
        ] 
     );

    }


}
