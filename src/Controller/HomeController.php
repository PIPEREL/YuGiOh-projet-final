<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\CarrousselRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategorieRepository $categorieRepository, CarrousselRepository $carrousselRepository): Response
    {
        if ($this->getUser() !== null) {

            $request = Request::createFromGlobals();

            $cookies = $request->cookies;
            $response = new Response();

            if (!$cookies->has('lightmode')) {
                $cookie = Cookie::create('lightmode')
                    ->withValue("off")
                    ->withExpires(time() + 36000)
                    ->withHttpOnly(false);
                $response->headers->setCookie($cookie);
                $response->sendHeaders();
            }
        }

        $carroussel = $carrousselRepository->findOneby(array('nom' => 'home'));
        $categories = $categorieRepository->findNouveau();
        $prochainement = $categorieRepository->findSoon();
        return $this->render('home/index.html.twig', [
            "categories" => $categories,
            'carroussel' => $carroussel,
            'prochains' => $prochainement,
        ]);
    }
}
