<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Commande;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    #[Route('admin/user/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('admin/user/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('admin/user/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('admin/user/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('plainPassword')->getData();
           
            if ($password !== null) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $password
                    )
                );


            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('admin/user/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route('user/', name: 'currentuser_index')]
    public function myaccount()
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        return $this->renderForm('user/index.html.twig', [
            'user' => $user,
        ]);

    }

    #[Route('user/commande', name: 'currentuser_commande')]
    public function mycommandes(CommandeRepository $commandeRepository, UserRepository $userRepository)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }
        $user = $userRepository->find($this->getUser());
        $commandes = $user->getCommandes();


        return $this->renderForm('user/commande.html.twig', [
            'user' => $user,
            'commandes'=> $commandes 
        ]);

    }

    
    #[Route('user/commande/detail/{id}', name: 'currentuser_commandedetail', methods: ['GET', 'POST'] )]
    public function mycommandetails(Commande $commande, UserRepository $userRepository)
    {
        if ($this->getUser() == null || $this->getUser() != $commande->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $user = $userRepository->find($this->getUser());
        // $details = $commande->getArticleCommandes();


        return $this->renderForm('user/detailCommande.html.twig', [
            'user' => $user,
            'commande'=> $commande,
        ]);

    }

    #[Route('user/info', name: 'currentuser_info')]
    public function myinfo()
    {
        if ($this->getUser() == null ) {
            return $this->redirectToRoute('app_login');
        }
       
        $user = $this->getUser();
        // $details = $commande->getArticleCommandes();


        return $this->renderForm('user/mesinformations.html.twig', [
            'user' => $user,
        ]);

    }
    #[Route('user/info/edit', name: 'currentuser_edit', methods: ['GET','POST'])]
    public function myinfoedit(UserRepository $userRepository, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if ($this->getUser() == null ) {
            return $this->redirectToRoute('app_login');
        }    
        $user = $userRepository->find($this->getUser());

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('plainPassword')->getData();

            if ($password !== null) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $password
                    )
                );

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('currentuser_info', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/editmesinfo.html.twig', [
            'user' => $user,
            'form' => $form
        ]);

    }
    


}
