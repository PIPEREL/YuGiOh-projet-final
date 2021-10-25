<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CarrousselRepository;
use App\Repository\CategorieRepository;
use App\Service\ApiCardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{

    #[Route('admin/article/new', name: 'article_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg = $form['img']->getData();
            $extensionImg = $infoImg->guessExtension();
            $nomImg = time() . 'img.' . $extensionImg;
            if (!file_exists($this->getParameter('article_folder'))) {
                mkdir($this->getParameter('article_folder')); // crée le dossier
            }
            $infoImg->move($this->getParameter('article_folder'), $nomImg);
            $article->setImg($nomImg);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('admin/article/{id}', name: 'article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('admin/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('admin/article/{id}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //gestion img
            $infoImg = $form['img']->getData();
            if ($infoImg !== null) {
                $nomOldImg = $article->getImg();
                $cheminOldImg =  $this->getParameter('article_folder') . '/' . $nomOldImg;
                if (file_exists($cheminOldImg)) {
                    unlink($cheminOldImg);
                }
                $extensionImg = $infoImg->guessExtension();
                $nomImg = time() . 'img.' . $extensionImg;
                $infoImg->move($this->getParameter('article_folder'), $nomImg);
                $article->setImg($nomImg);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('admin/article/{id}', name: 'article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {

            $nomImg = $article->getImg();
            if ($nomImg !== null) {
                $cheminImg = $this->getParameter('article_folder') . '/' . $nomImg;
                if (file_exists($cheminImg)) {
                    unlink($cheminImg);
                }
            }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($article);
                $entityManager->flush();
            

            return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    
    #[Route('article/{id}', name: 'article_content', methods: ['GET'])]
    public function Contentarticle(Article $article, ApiCardService $apiCardService): Response
    {
        $name = $article->getNom();
        $detail= $apiCardService->getCards($name)['data'][0];
        return $this->render('magasin/article.html.twig', [
            'article' => $article,
            'detail' => $detail
        ]);
    }

    #[Route('article/search', name: 'article_search', methods: ['POST'])]
    public function searchArticle(Request $request,ArticleRepository $articleRepository,CategorieRepository $categoriesRepository): Response
    {
        if ($request->request->get('rechercher') !== null) {
            $recherche = $request->request->get('rechercher');
            $anArticle = $articleRepository->findOneBy(array('nom'=>$recherche));
            if($anArticle !== null){     
            return $this->redirectToRoute('article_content', ['id' => $anArticle->getId()]);
            }
            $categories= $categoriesRepository->findByWord($recherche);
            $articles = $articleRepository->findByWord($recherche);
            if($categories == null && $articles == null){
                $this->addFlash('failedresearch', 'Erreur : votre recherche ne renvoie vers aucun contenu');
            }

            return $this->render('magasin/recherche.html.twig', [
            "categories" => $categories,
            "articles" => $articles 
            ]);
        }
       
        return $this->redirectToRoute('home');
    }
}
