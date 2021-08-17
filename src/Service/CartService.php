<?php

namespace App\Service;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $sessionInterface;

    public function __construct(SessionInterface $sessionInterface)
    {
        $this->sessionInterface = $sessionInterface;
    }

    public function get()
    {
        $cart = $this->sessionInterface->get('cart', ['total' => 0, 'livraison' =>['type'=>'untracked','prix'=> 5] , 'elements' => []]);
        return $cart;
    }

    public function add(Article $article, int $quantity = 1)
    {
        $cart = $this->get();

        $articleId = $article->getid();
        if (!isset($cart['elements'][$articleId])) {
            $cart['elements'][$articleId] = ['article' => $article, 'quantity' => 0];
        }
        if (!empty($cart['elements'][$articleId])) {
            if ($cart['elements'][$articleId]['quantity'] < $article->getStock()) {
                $cart['elements'][$articleId]['quantity'] += $quantity;
            } else if ($cart['elements'][$articleId]['quantity'] > $article->getStock()) {
                $cart['elements'][$articleId]['quantity'] = $article->getStock();
            }
        } else {
            $cart['elements'][$articleId]['quantity'] = $quantity;
        }

    
        $this->sessionInterface->set('cart', $cart);
        $cart['total'] = $this->getTotal();
        $this->sessionInterface->set('cart', $cart);
    }

    public function minus(Article $article)
    {
        $cart = $this->get();

        $articleId = $article->getid();

        if (isset($cart['elements'][$articleId])) {

            $cart['elements'][$articleId]['quantity'] -=  1;
            if ($cart['elements'][$articleId]['quantity'] <= 0) {
                unset($cart['elements'][$articleId]);
            }
        }
        $this->sessionInterface->set('cart', $cart);
        $cart['total'] = $this->getTotal();
        $this->sessionInterface->set('cart', $cart);
    }

    
    public function removeArticle(Article $article)
    {
        $cart = $this->get();
        
        $articleId = $article->getid();
        
         if (isset($cart['elements'][$articleId])){
         unset($cart['elements'][$articleId]);
        }
        $this->sessionInterface->set('cart', $cart);
        $cart['total'] = $this->getTotal();
        $this->sessionInterface->set('cart', $cart);
    }





    public function clear(){
        $this->sessionInterface->remove('cart');
    }




    public function getTotal()
    {
        $total = 0;
        $panier = $this->get();

        foreach ($panier['elements'] as $element) {
            $total += $element['article']->getPrix() * $element['quantity'];
        }
        

        return $total;
    }

    public function getQteTotal(): int
    {
        $qte = 0;
        $panier = $this->get();

        foreach ($panier['elements'] as $element) {
            $qte += $element['quantity'];
        }
        return $qte;

    }

    public function livraison($data)
    {
        $cart = $this->get();
        $livraison = $data['Livraison'];
        if($livraison == 'tracked'){
           $cart['livraison'] = ['type'=> 'tracked', 'prix'=>'10'];
        }else{
            $cart['livraison'] = ['type'=> 'untracked', 'prix'=>'5'];
        }
        $this->sessionInterface->set('cart', $cart);
    }

}
