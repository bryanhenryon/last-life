<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use App\Entity\Membre;
use App\Form\MembreType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function register(Request $Request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {
        $membre = new Membre();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(MembreType::class, $membre);

        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
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

            $message = (new \Swift_Message('Bienvenue !'))
            ->setFrom(['lastlifeblog@gmail.com' => 'Last Life'])
            ->setTo($data->getEmail())
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'base/registration.html.twig',['data' => $data]
                ),
                'text/html'
            );
    
        $mailer->send($message);

            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', [
            'formMembre' => $form->createView()
        ]);
    }

    /**
     * @Route("/forgotten_password", name="app_forgotten_password")
     */
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {

        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(Membre::class)->findOneByEmail($email);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Cette adresse email n\'existe pas');
                return $this->redirectToRoute('homepage');
            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('homepage');
            }

            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Demande de réinitialisation de mot de passe'))
                ->setFrom(['lastlifeblog@gmail.com' => 'Last Life'])
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'base/password_reset_mail.html.twig',['url' => $url]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', 'Votre demande a bien été prise en compte, un email de réinitialisation de mot de passe vous a été envoyé');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/forgotten_password.html.twig');
    }

     /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(Membre::class)->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Token inconnu');
                return $this->redirectToRoute('homepage');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été réinitialisé');

            return $this->redirectToRoute('login');

        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }

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