<?php

namespace App\classe;

use Symfony\Component\HttpFoundation\RequestStack;
 
 
class Cart
{
    private $stack;
 
    public function __construct(RequestStack $stack)
 
    {
        $this->stack = $stack;
    }
 
    public function add($id)
    {
 
        $session = $this->stack->getSession();
        $cart = $session->get('cart', []);
 
        if(!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
 
 
        $session->set('cart', $cart);
    }
 
    public function get()
    {
        $methodget= $this->stack->getSession();
        return $methodget->get('cart');
    }

    public function remove(){
 
       $methodremove = $this->stack->getSession();
        return $methodremove->remove('cart');
    }
    public function delete($id)
    {
        
        $session = $this->stack->getSession();
        $cart = $session->get('cart', []);

        unset($cart[$id]);
       
        return $session->set('cart',$cart);
    
    }
    public function decrease($id)
    {
        
        $session = $this->stack->getSession();
        $cart = $session->get('cart', []);

        if($cart[$id]>1 ){
            $cart[$id]--;

        } else {
            //supprimer mon produit (-1)
            unset($cart[$id]);
        }

        
       
        return $session->set('cart',$cart);
    
    }
}
