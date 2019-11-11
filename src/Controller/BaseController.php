<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
     /**
     * @Route("/contact/", name="contact")
     *
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {

        $form = $this->createForm(ContactFormType::class, NULL);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($this->sendEmail($data, $mailer)) {
                $this->addFlash('success', 'Votre message a bien été envoyé ! Nous vous recontacterons dans les meilleurs délais');
            } else {
                $this->addFlash('errors', 'Erreur lors de l\'envoi du message');
            }

            return $this->redirectToRoute('homepage');
        }

        $params = array(
            'contactForm' => $form->createView()
        );

        return $this->render('base/contact.html.twig', $params);
    }



    /**
     * @Route("/contact_mail" , name="contact_mail")
     */
    public function sendEmail($data, \Swift_Mailer $mailer)
    {
        // On crée l'email ( en précisant l'objet )
        $mail = new \Swift_Message('Last Life : ' . $data['objet']);

        // On configure l'email ( Qui , pour qui , quoi , comment )

        $mail
            ->setFrom($data['email'])
            ->setTo('lastlifeblog@gmail.com')
            ->setBody(
                $this->renderView('base/contact_mail.html.twig', array('data' => $data)),
                'text/html'
            );

        // On demande au mailer d'envoyer l'email

        if (!$mailer->send($mail)) {
            return false;
        }
        return true;
    }

    /**
     * @Route("/mentions_legales", name="mentions_legales")
     */
    public function mentionsLegales(){
        return $this->render('base/mentions_legales.html.twig');
    }
}
