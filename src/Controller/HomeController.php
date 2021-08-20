<?php

namespace App\Controller;

use App\Repository\CarrousselRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategorieRepository $categorieRepository, CarrousselRepository $carrousselRepository): Response
    {   
        $carroussel = $carrousselRepository->findOneby(array('nom'=>'home'));
        $categories = $categorieRepository->findNouveau();
        $prochainement = $categorieRepository->findSoon();
        return $this->render('home/index.html.twig', ["categories"=> $categories,
        'carroussel' => $carroussel,
        'prochains' => $prochainement,
        ]);
    }
}
