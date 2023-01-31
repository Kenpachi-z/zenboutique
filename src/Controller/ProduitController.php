<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Classe\Search;
use App\Form\SearchType;
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
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        return $this->render('produit/index.html.twig',[
            'produit'=>$produit,
            'form'=> $form->createView()
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
