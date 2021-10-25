<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, UserRepository $userRepository): Response
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('home');
        }
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($userRepository->findOneBy(['email' => $form->get('email')->getData()]) !== null){
                $this->addFlash('error', 'Erreur, Cette adresse email existe déjà');
                return $this->redirectToRoute('app_register');
            } else {
                $user->setEmail($form->get('email')->getData());
            }
            // encode the plain password
            if($form->get('plainPassword') == $form->get('confirmPassword')){
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
        } else{
            $this->addFlash('error', 'erreur vos mot de passes ne correspondent pas');
            return $this->redirectToRoute('app_register');
        }
        

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            $message =(new \Swift_Message('Bienvenue Chez Yugioh build&buy'))
                ->setFrom('bastienpiperel@gmail.com')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('registration/RegistrationContact.html.twig', [
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'email' => $user->getEmail(),
                ]),
                'text/html'
            );
            $mailer->send($message);


            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
