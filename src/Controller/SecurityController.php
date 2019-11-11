<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use App\Entity\Membre;
use App\Form\MembreType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function register(Request $Request, UserPasswordEncoderInterface $encoder)
    {
        $membre = new Membre();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(MembreType::class, $membre);

        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($membre);
            $password = $membre->getPassword();
            $password_crypte = $encoder->encodePassword($membre, $password);
            $membre->setPassword($password_crypte);
            $membre -> setDateTimeRegistry($datetime = new \DateTime('now',new \DateTimeZone('UTC')));
            $datetime->modify('+2 hour');
            $membre->setRole('ROLE_USER');
            $em->flush();

            $this->addFlash(
                'success',
                'Merci de votre inscription ! Vous pouvez maintenant vous connecter.'
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', [
            'formMembre' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $auth)
    {

        $lastUsername = $auth -> getLastUserName(); 
        $error = $auth -> getLastAuthenticationError(); 

        if(!empty($error))
        {
            $this->addFlash(
                'danger',
                'Aucun compte ne correspond au pseudo et au mot de passe saisis. Assurez-vous d\'avoir saisi les bonnes informations et essayez à nouveau.'
            );
        }

        return $this->render('security/login.html.twig', array(
            'lastUsername' => $lastUsername
        ));

    }

    /**
     * @Route("/logout/", name="logout")
     *
     */
    public function logout()
    { }
}