<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findNouveau();
        return $this->render('admin/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
