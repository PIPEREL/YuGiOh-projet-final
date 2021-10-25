<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Adresses;
use App\Entity\Commande;
use App\Form\UserEditType;
use App\Form\AdressesUserType;
use App\Repository\UserRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Cookie;
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
                $passwordEncoder->encodePassword( // bcrypt 
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
        $adresses = $user->getAdresses();
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,         
            'adresses'=> $adresses
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
        $commandes = $commandeRepository->findby(['user'=> $user],['Date_creation' => 'DESC']);


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
    public function myinfo(Request $request):response
    {
        if ($this->getUser() == null ) {
            return $this->redirectToRoute('app_login');
        }
       
        $user = $this->getUser();
        // $details = $commande->getArticleCommandes();
        if ($request->request->get('toggle') !== null) {
            $request = Request::createFromGlobals();
            $cookies = $request->cookies->get('lightmode');
            $response = new Response();

            if($request->request->get('toggle-night') == "on"){
                $cookie = Cookie::create('lightmode')
                    ->withValue("on")
                    ->withExpires(time() + 36000)
                    ->withHttpOnly(false);      
            }else{
                $cookie = Cookie::create('lightmode')
                ->withValue("off")
                ->withExpires(time() + 36000)
                ->withHttpOnly(false);      
            }
            $response->headers->setCookie($cookie);
            $response->sendHeaders();
            return $this->redirectToRoute('currentuser_info');
        }


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
             $oldpassword = $form->get('oldPassword')->getData();
             $test = $passwordEncoder->isPasswordValid($user, $oldpassword);
             if ($password !== null) {
               if($test == false){
                   $this->addFlash('wrongOldPassword', "L'ancien mot de passe ne correspond pas");
                     return $this->redirectToRoute('currentuser_edit');
                 }
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
    
    #[Route('user/info/adresses', name: 'currentuser_adresses')]
    public function myadresses()
    {
        if ($this->getUser() == null ) {
            return $this->redirectToRoute('app_login');
        }
       
        $user = $this->getUser();
        $adresses = $user->getAdresses();
        // $details = $commande->getArticleCommandes();

        return $this->renderForm('user/UserAdresses.html.twig', [
            'user' => $user,
            'adresses' => $adresses
        ]);

    }

    #[Route('user/info/adresses/{id}/edit', name: 'currentuser_adresse_edit', methods: ['GET', 'POST'])]
    public function editadresse(Request $request, Adresses $adress): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }

        if( $this->getUser() != $adress->getUser()){
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(AdressesUserType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('currentuser_adresses', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/UserEditAdresses.html.twig', [
            'adress' => $adress,
            'form' => $form,
        ]);
    }

    #[Route('user/info/adresses/new', name: 'currentuser_adresses_new', methods: ['GET', 'POST'])]
    public function new_user_adresse(Request $request): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }
        $adress = new Adresses();
        $form = $this->createForm(AdressesUserType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adress->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adress);
            $entityManager->flush();

            return $this->redirectToRoute('currentuser_adresses', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/UserNewAdress.html.twig', [
            'adress' => $adress,
            'form' => $form,
        ]);
    }

}
