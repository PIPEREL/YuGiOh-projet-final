<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adresses;
use App\Form\AdressesType;
use App\Repository\AdressesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdressesController extends AbstractController
{
    #[Route('admin/adresses/new', name: 'adresses_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $adress = new Adresses();
        $form = $this->createForm(AdressesType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adress);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/adresses/new.html.twig', [
            'adress' => $adress,
            'form' => $form,
        ]);
    }

    #[Route('admin/adresses/{id}/edit', name: 'adresses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Adresses $adress): Response
    {
        $form = $this->createForm(AdressesType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/adresses/edit.html.twig', [
            'adress' => $adress,
            'form' => $form,
        ]);
    }

    #[Route('admin/adresses/{id}', name: 'adresses_delete', methods: ['POST'])]
    public function delete(Request $request, Adresses $adress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route('adresses/delete/{id}', name: 'adresses_user_delete', methods: ['POST'])]
    public function delete_adresse(Request $request, Adresses $adress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('currentuser_adresses', [], Response::HTTP_SEE_OTHER);
    }

  

}
