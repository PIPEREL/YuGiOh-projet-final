<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ContactType::class); // crée un formulaire de contact
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { // formulaire soumis et valide
            $contact = $form->getData(); // recup les données 

            $mail = (new \Swift_Message('ProjetYugi : contact ')) //prepare le mail
                ->setFrom($contact['email'], $contact['email']) // défini l'expediteur
                ->setTo('bastienpiperel@gmail.com') // définit le destinataire
                ->setBody(
                    $this->renderView('contact/emailContact.html.twig', [
                        'nom' => $contact['Nom'],
                        'prenom' => $contact['Prenom'],
                        'email' => $contact['email'],
                        'objet' => $contact['objet'],
                        'message' => $contact['message'],

                    ]),
                    'text/html'
                ); // définit le corps du message text/html défini le format du mail a envoyer

                $mailer->send($mail);
                $this->addFlash('mailSuccess', 'Votre mail à été envoyé avec succès!');
                return $this->redirectToRoute('contact');
            }


                return $this->render('contact/index.html.twig', [
                    'contactForm' => $form->createView()
                ]);
            
        }
      
}
