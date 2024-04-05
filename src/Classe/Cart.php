<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack)
    {
        
    }

    /*
    * add()
    *Fonction permettant l'ajout d un produit au panier
     */
    public function add($product)
    {
        $cart = $this->requestStack->getSession()->get('cart') ?? []; // Assurez-vous que $cart est toujours initialisé

        if(isset($cart[$product->getId()])) { // Vérifiez si l'élément existe
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1
            ];
        } else { 
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => 1
            ];
        }
    
        $this->requestStack->getSession()->set('cart', $cart);
    }

    /*
    *getCart()
    * fonction retournant le panier
    */
    public function getCart()
    {
        $cart = $this->requestStack->getSession()->get('cart') ?? []; // Assurez-vous que $cart est toujours initialisé
        // dd($cart);  Déplacez dd() avant return si vous voulez qu'il soit exécuté
        return $cart;
    }


    /*
    *remove()
    * fonction permettant de supprimer le panier
    */
    public function remove()
    {
      return $this->requestStack->getSession()->remove('cart');
    }

    /*
    *decrease()
    * fonction permettant la supprimer dans le panier d'une quantité du produit
    */
    public function decrease($id)
{
    $cart =  $this->requestStack->getSession()->get('cart');

    if($cart[$id]['qty'] > 1){
        $cart[$id]['qty']=$cart[$id]['qty'] - 1 ;

    } else { 
        unset($cart[$id]);
    }
    $this->requestStack->getSession()->set('cart',$cart);
}

    /*
    *fullQuantity()
    * fonction retournant le nombre de produit total au panier
    */
    public function fullQuantity()
    {
        $cart =  $this->requestStack->getSession()->get('cart');

        $quantity=0;

        if(!isset($cart)) {
            return $quantity;
        }

        foreach ($cart as $product){
            $quantity = $quantity + $product ['qty'];
        }


        return $quantity ;

    }

    /*
    *getTotalWt()
    * fonction retournant le prix total ttc du panier
    */
    public function getTotalWt(){

        $cart =  $this->requestStack->getSession()->get('cart');

        $price=0;

        if(!isset($cart)) {
            return $price;
        }

        foreach ($cart as $product){
            $price = $price + $product['object']->getPriceWt() * $product ['qty'];
        }
        return $price;

        


    }
}


    

