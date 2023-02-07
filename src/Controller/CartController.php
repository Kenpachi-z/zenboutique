<?php

namespace App\Controller;

use App\classe\Cart;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(entityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }




    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response

    {
        $cartComplete = [];

        foreach ($cart->get() as $id => $quantity) {
            $cartComplete[] = [
                'produit'=> $this->entityManager->getRepository(Produit::class)->findOneById($id),
                'quantity'=> $quantity
            ];
        }

      
       
        return $this->render('/cart/index.html.twig',[
            'cart'=>$cartComplete
        ]);
    }
    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id): Response 
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }
    #[Route('/cart/remove', name: 'app_remove_my_cart')]
    public function remove(Cart $cart): Response 
    {
        $cart->remove();
        return $this->redirectToRoute('app_produit');
   
    }

    #[Route('/cart/delete/{id} ', name: 'app_delete_to_cart')]
    public function delete(Cart $cart, $id): Response 
    {
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }
}
