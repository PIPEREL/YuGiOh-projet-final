<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('admin/commande', name: 'commande')]
    public function index(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findall();
        return $this->render('admin/commande/index.html.twig', [
           "commandes" => $commandes, 
        ]);
    }


    #[Route('admin/commande/detail/{id}', name: 'commande_detail', methods: ['GET', 'POST'] )]
    public function mycommandetails(Commande $commande)
    {
    
        // $details = $commande->getArticleCommandes();
        return $this->renderForm('admin/commande/detailCommande.html.twig', [
            'commande'=> $commande,
        ]);

    }
}
