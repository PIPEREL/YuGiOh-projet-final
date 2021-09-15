<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategorieController extends AbstractController
{
    #[Route('admin/categorie/', name: 'categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('admin/categorie/new', name: 'categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg1 = $form['img1']->getData();
            $extensionImg1 = $infoImg1->guessExtension();
            $nomImg1 = time() . 'img1.' . $extensionImg1;
            if (!file_exists($this->getParameter('categorie_folder'))) {
                mkdir($this->getParameter('categorie_folder')); // crée le dossier
            }
            $infoImg1->move($this->getParameter('categorie_folder'), $nomImg1);
            $categorie->setImg1($nomImg1);

            $infoImg2 = $form['img2']->getData();
            if ($infoImg2 !== null) {
                $extensionImg2 = $infoImg2->guessExtension();
                $nomImg2 = time() . 'img2.' . $extensionImg2;
                $infoImg2->move($this->getParameter('categorie_folder'), $nomImg2);
                $categorie->setImg2($nomImg2);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('admin/categorie/{id}', name: 'categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        $articles= $categorie->getArticles();
        return $this->render('admin/categorie/show.html.twig', [
            'categorie' => $categorie,
            'articles' => $articles
        ]);
    }

    #[Route('admin/categorie/{id}/edit', name: 'categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                //gestion img1
                $infoImg1 = $form['img1']->getData();
                if ($infoImg1 !== null) {
                    $nomOldImg1 = $categorie->getImg1(); 
                    $cheminOldImg1 =  $this->getParameter('categorie_folder') . '/' . $nomOldImg1; 
                    if (file_exists($cheminOldImg1)) { 
                        unlink($cheminOldImg1); 
                    }
                    $extensionImg1 = $infoImg1->guessExtension(); 
                    $nomImg1 = time() . 'img1.' . $extensionImg1; 
                    $infoImg1->move($this->getParameter('categorie_folder'), $nomImg1); 
                    $categorie->setImg1($nomImg1);
                }

                // gestion img2 
                $infoImg2 = $form['img2']->getData();
                if ($infoImg2 !== null) {
                    $nomOldImg2 = $categorie->getImg2(); 
                    if ($nomOldImg2 !== null) {
                        $cheminOldImg2 = $this->getParameter('categorie_folder') . '/' . $nomOldImg2;
                        if (file_exists($cheminOldImg2)) { 
                            unlink($cheminOldImg2); 
                        }
                    }
                    $extensionImg2 = $infoImg2->guessExtension(); 
                    $nomImg2 = time() . 'img2.' . $extensionImg2;  
                    $infoImg2->move($this->getParameter('categorie_folder'), $nomImg2); 
                    $categorie->setImg2($nomImg2);
                }


                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
            }
        

            return $this->renderForm('admin/categorie/edit.html.twig', [
                'categorie' => $categorie,
                'form' => $form,
            ]);
        
    }

    #[Route('admin/categorie/{id}', name: 'categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('_token'))) {

            $nomImg1 = $categorie->getImg1();
            $nomImg2 = $categorie->getImg2();
            if ($nomImg1 !== null) {
                $cheminImg1 = $this->getParameter('categorie_folder') . '/' . $nomImg1;
                if (file_exists($cheminImg1)) {
                    unlink($cheminImg1);
                }
                if ($nomImg2 !== null){
                    $cheminImg2 = $this->getParameter('categorie_folder') . '/' . $nomImg2;
                if (file_exists($cheminImg2)) {
                    unlink($cheminImg2);
                }
            }
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('categorie/', name: 'categorie_client', methods: ['GET'])]
    public function indexClient(CategorieRepository $categorieRepository): Response
    {
        return $this->render('magasin/categories.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('categorie/{id}', name: 'categorie_content', methods: ['GET'])]
    public function ContentCategorie(Categorie $categorie, ArticleRepository $articleRepository): Response
    {
        // $articles = $categorie->getArticles();
        $articles = $articleRepository->findby(['categorie'=>$categorie], ['libelle'=>"ASC"]);
        return $this->render('magasin/contentCat.html.twig', [
            'articles' => $articles,
            'categorie' => $categorie
        ]);
    }
}
