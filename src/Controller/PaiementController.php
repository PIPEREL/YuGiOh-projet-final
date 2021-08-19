<?php

namespace App\Controller;

use DateTime;

use App\Service\CartService;
use App\Service\CommandeService;
use App\Service\PaiementService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{

    #[Route('/paiement/success/{stripeSessionId}', name: 'paiement_success')]
    public function success(string $stripeSessionId,PaiementService $paiementService, CommandeService $commandeService, CartService $cartService): Response
    {
        try{
        $test = $paiementService->exists($stripeSessionId);
        }catch(Exception $test){
            return $this->redirectToRoute('paiement_failure');
        }

        if($test == false){
            return $this->redirectToRoute('paiement_failure');
        }
        $response = $paiementService->retrieve($stripeSessionId);
        $commande = $commandeService->New($stripeSessionId);
        $commandeService->add($commande);
        $cartService->clear();

        return $this->render('paiement/success.html.twig', [
            
        ]);
    }

    // #[Route('/paiement/failure/{stripeSessionId}', name: 'paiement_failure')]
    // public function failure(string $stripeSessionId): Response
    // {
    //     return $this->render('paiement/failure.html.twig', [

    //     ]);
    // }

    #[Route('/paiement/failure', name: 'paiement_failure')]
    public function failure(): Response
    {
        return $this->render('paiement/failure.html.twig', [

        ]);
    }
}