<?php

namespace App\Controller;

use App\Entity\Carroussel;
use App\Form\CarrousselType;
use App\Repository\CarrousselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/carroussel')]
class CarrousselController extends AbstractController
{
    #[Route('/', name: 'carroussel_index', methods: ['GET'])]
    public function index(CarrousselRepository $carrousselRepository): Response
    {
        return $this->render('admin/carroussel/index.html.twig', [
            'carroussels' => $carrousselRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'carroussel_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $carroussel = new Carroussel();
        $form = $this->createForm(CarrousselType::class, $carroussel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $infoImage1 = $form['image1']->getData();
            $extensionImage1 = $infoImage1->guessExtension();
            $nomImage1 = time() . 'image1.' . $extensionImage1;
            if (!file_exists($this->getParameter('carroussel_folder'))) {
                mkdir($this->getParameter('carroussel_folder')); // crée le dossier
            }
            $infoImage1->move($this->getParameter('carroussel_folder'), $nomImage1);
            $carroussel->setImage1($nomImage1);

            $infoImage2 = $form['image2']->getData();
            if ($infoImage2 !== null) {
                $extensionImage2 = $infoImage2->guessExtension();
                $nomImage2 = time() . 'image2.' . $extensionImage2;
                $infoImage2->move($this->getParameter('carroussel_folder'), $nomImage2);
                $carroussel->setImage2($nomImage2);
            }

            $infoImage3 = $form['image3']->getData();
            if ($infoImage3 !== null) {
                $extensionImage3 = $infoImage3->guessExtension();
                $nomImage3 = time() . 'image3.' . $extensionImage3;
                $infoImage3->move($this->getParameter('carroussel_folder'), $nomImage3);
                $carroussel->setImage3($nomImage3);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carroussel);
            $entityManager->flush();

            return $this->redirectToRoute('carroussel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/carroussel/new.html.twig', [
            'carroussel' => $carroussel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'carroussel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carroussel $carroussel): Response
    {
        $form = $this->createForm(CarrousselType::class, $carroussel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //gestion image1
            $infoImage1 = $form['image1']->getData();
            if ($infoImage1 !== null) {
                $nomOldImage1 = $carroussel->getImage1();
                $cheminOldImage1 =  $this->getParameter('carroussel_folder') . '/' . $nomOldImage1;
                if (file_exists($cheminOldImage1)) {
                    unlink($cheminOldImage1);
                }
                $extensionImage1 = $infoImage1->guessExtension();
                $nomImage1 = time() . 'image1.' . $extensionImage1;
                $infoImage1->move($this->getParameter('carroussel_folder'), $nomImage1);
                $carroussel->setImage1($nomImage1);
            }

            // gestion image2 
            $infoImage2 = $form['image2']->getData();
            if ($infoImage2 !== null) {
                $nomOldImage2 = $carroussel->getImage2();
                if ($nomOldImage2 !== null) {
                    $cheminOldImage2 = $this->getParameter('carroussel_folder') . '/' . $nomOldImage2;
                    if (file_exists($cheminOldImage2)) {
                        unlink($cheminOldImage2);
                    }
                }
                $extensionImage2 = $infoImage2->guessExtension();
                $nomImage2 = time() . 'image2.' . $extensionImage2;
                $infoImage2->move($this->getParameter('carroussel_folder'), $nomImage2);
                $carroussel->setImage2($nomImage2);
            }  
            
            $infoImage3 = $form['image3']->getData();
            if ($infoImage3 !== null) {
                $nomOldImage3 = $carroussel->getImage3();
                if ($nomOldImage3 !== null) {
                    $cheminOldImage3 = $this->getParameter('carroussel_folder') . '/' . $nomOldImage3;
                    if (file_exists($cheminOldImage3)) {
                        unlink($cheminOldImage3);
                    }
                }
                $extensionImage3 = $infoImage3->guessExtension();
                $nomImage3 = time() . 'image3.' . $extensionImage3;
                $infoImage3->move($this->getParameter('carroussel_folder'), $nomImage3);
                $carroussel->setImage3($nomImage3);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('carroussel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/carroussel/edit.html.twig', [
            'carroussel' => $carroussel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'carroussel_delete', methods: ['POST'])]
    public function delete(Request $request, Carroussel $carroussel): Response
    {
        if ($this->isCsrfTokenValid('delete' . $carroussel->getId(), $request->request->get('_token'))) {
            $nomImage1 = $carroussel->getImage1();
            $nomImage2 = $carroussel->getImage2(); 
            $nomImage3 = $carroussel->getImage3();
            if ($nomImage1 !== null) {
                $cheminImage1 = $this->getParameter('carroussel_folder') . '/' . $nomImage1;
                if (file_exists($cheminImage1)) {
                    unlink($cheminImage1);
                }
                if ($nomImage2 !== null){
                    $cheminImage2 = $this->getParameter('carroussel_folder') . '/' . $nomImage2;
                if (file_exists($cheminImage2)) {
                    unlink($cheminImage2);
                }
            }      if ($nomImage3 !== null){
                    $cheminImage3 = $this->getParameter('carroussel_folder') . '/' . $nomImage3;
                if (file_exists($cheminImage3)) {
                    unlink($cheminImage3);
                }
            }
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carroussel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('carroussel_index', [], Response::HTTP_SEE_OTHER);
    }
}
