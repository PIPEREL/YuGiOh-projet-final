<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Commande;
use App\Entity\CommandeDetail;
use App\Entity\ArticleCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class CommandeService
{
    private $cartService;
    private $security;

    public function __construct(CartService $cartService, EntityManagerInterface $em, Security $security)
    {
        $this->cartService = $cartService;
        $this->em = $em;
        $this->security = $security;
    }


    public function New(string $stripeSessionId){
        $panier = $this->cartService->get();
        $time = new DateTime('NOW');
        $commande = new Commande;
        $commande->setPrixTotal($panier['total']+$panier['livraison']['prix']);
        $commande->setTypeLivraison($panier['livraison']['type']);
        $commande->setUser($this->em->getRepository(User::class)->find($this->security->getUser()));
        $commande->setDateCreation($time);
        $commande->setReference($stripeSessionId);
        return $commande;

    }

    public function Add(Commande $commande){
    $panier = $this->cartService->get();

    foreach ($panier['elements'] as $element){
        $articleCommande = new ArticleCommande;
        // $articleCommande->setBook($element['book']);
        $articleCommande->setQuantity($element['quantity']);
        $article = $this->em->getRepository(Article::class)->find($element['article']->getId());
        $article->setStock($article->getStock() - $element['quantity']);
        $article->addarticleCommande($articleCommande);
        // $this->em->persist($book);
      
        // $element['book']->addarticleCommande($articleCommande);
        $commande->addarticleCommande($articleCommande);
        $this->em->persist($article);
 
    }
    $this->em->persist($commande);
    $this->em->flush();

    }

}