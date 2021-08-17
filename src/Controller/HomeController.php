<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategorieRepository $categorieRepository): Response
    {   
        $categories = $categorieRepository->findNouveau();
        return $this->render('home/index.html.twig', ["categories"=> $categories,
        ]);
    }
}
