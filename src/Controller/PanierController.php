<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\CartService;
use App\Service\PaiementService;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(CartService $cartService, Request $request): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }
        $livraison= [];
        $form = $this->createFormBuilder($livraison)
        ->add(
            'Livraison',
            ChoiceType::class,
            [
                'choices' => ['Livraison non suivie - 5.00 $' => 'untracked', 'Livraison Suivie - 10.00 $' => 'tracked'],
                'expanded' => false,
                'multiple' => false,
            ]
        )
        ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartService->livraison($form->getData());
        }


        $panier = $cartService->get();
        $qte = $cartService->getQteTotal();  
        return $this->render('panier/index.html.twig', [
          'panier' => $panier,
          'qte' => $qte,
          'form' => $form->createView(),
        ]);
    }

    #[Route('/panier/confirmation', name: 'panier_confirmation')]
    public function confirmation(CartService $cartService): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }
        $panier = $cartService->get();

        $qte = $cartService->getQteTotal();  
        return $this->render('panier/confirmation.html.twig', [
          'panier' => $panier,
          'qte' => $qte,
        ]);
    }
    
    #[Route('/panier/valider', name: 'panier_valider')]
    public function validate(PaiementService $paymentService, CartService $cartService, ArticleRepository $articleRepository):Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }
        $panier = $cartService->get();
        $change = false; 
        foreach($panier['elements'] as $element){
            $article = $articleRepository->find($element['article']);
            $articleStock = $article->getStock();
            if($articleStock < $element['quantity']){
                $cartService->setQuantity($article, $articleStock);
                $change = true;
            }
        }
        if ($change == true){
            $this->addFlash('echecpaiement', 'Stock insuffisant pour certains articles, votre panier a été mis à jour.');
            return $this->redirectToRoute('panier');
        }
            $stripeSessionId = $paymentService->create();
        return $this->render('panier/redirect.html.twig', ['stripeSessionId' => $stripeSessionId]);
        

    }




    #[Route('/panier/ajouter', name: 'panier_add')]
    public function add(Request $request,ArticleRepository $articleRepository, CartService $CartService):Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }

        if ($request->request->get('id') !== null) {
            $article = $articleRepository->find( $request->request->get('id'));
            $quantity = $request->request->get('quantity');
            $CartService->add($article, $quantity);
        }

        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/plus/{id}', name: 'panier_plus')]
    public function plus(Article $article, CartService $CartService):Response
    {
        $CartService->add($article);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/minus/{id}', name: 'panier_minus')]
    public function minus(Article $article, CartService $CartService):Response
    {
        $CartService->minus($article);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/effacer/{id}', name: 'panier_effacer')]
    public function remove(Article $article, CartService $CartService):Response
    {
        $CartService->removeArticle($article);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/clear', name: 'panier_vider')]
    public function clear(CartService $CartService):Response
    {
        $CartService->clear();
        return $this->redirectToRoute('home');
    }

    
    #[Route('/panier/setquantity/{id}', name: 'panier_setQte')]
    public function setquantity(Request $request,Article $article, CartService $CartService):Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }

        if ($request->request->get('quantity') !== null && $request->request->get('quantity') != 0 ) {
            $quantity = $request->request->get('quantity');
            if($quantity<= $article->getStock()){
            $CartService->setquantity($article, $quantity);
            }else{
                $CartService->setquantity($article,$article->getStock());
            }
        }else{
            $CartService->removeArticle($article);
        }

        return $this->redirectToRoute('panier');
    }

}
