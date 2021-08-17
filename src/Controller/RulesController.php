<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RulesController extends AbstractController
{
    #[Route('/rules/cgu', name: 'cgu')]
    public function cgu(): Response
    {
        return $this->render('rules/cgu.html.twig', [
        ]);
    }
    #[Route('/rules/cgv', name: 'cgv')]
    public function cgv(): Response
    {
        return $this->render('rules/cgv.html.twig', [
        ]);
    }

    #[Route('/rules/cookies', name: 'cookies')]
    public function cookies(): Response
    {
        return $this->render('rules/cookies.html.twig', [
        ]);
    }
    #[Route('/rules/confidentialite', name: 'confidentialite')]
    public function confidentialite(): Response
    {
        return $this->render('rules/confidentialite.html.twig', [
        ]);
    }
    #[Route('/rules/qui', name: 'qui')]
    public function qui(): Response
    {
        return $this->render('rules/qui.html.twig', [
        ]);
    }
}
