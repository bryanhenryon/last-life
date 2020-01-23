<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use App\Entity\Membre;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\MembreType;
use App\Form\AccountType;
use App\Form\CommentType;
use App\Form\ContactFormType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BlogController extends AbstractController
{
        /**
         * @Route("/{page}", name="homepage", requirements={"page": "\d+"})
         */
        public function index(ArticleRepository $repo, $page = 1, ObjectManager $manager, Request $request)
        {
            $limit = 10;
            $start = $page * $limit - $limit;
        
            $total = count($repo->findAll());
            $pages = ceil($total / $limit); // 3.4 => 4
            
            $coucou = new Article();
            $article = $repo->findBy([], ['dateTimePublication' => 'DESC'], $limit, $start);
        
            if ($request->isMethod('POST')) {
            $search = $request->request->get('searchbar');
            dump($search);

            $manager->getRepository(Article::class)->findOneByTitre($search);
        
            }

            return $this->render('blog/index.html.twig', [
                'articles' => $article,
                'pages' => $pages,
                'page' => $page
            ]);

        }

        /**
         * @Route("article/{slug}", name="article")
         * @Route("categorie/{categorie}/article/{slug}", name="article_cat")
         */
        public function article($slug, ArticleRepository $repo, ObjectManager $manager, Request $request){
            
            $article = $repo->findOneBySlug($slug);
    
            $comment = new Comment();
            
            $form = $this->createForm(CommentType::class, $comment);
            
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()){
                $comment->setCreatedAt($datetime = new \DateTime('now',new \DateTimeZone('UTC')));
                $datetime->modify('+2 hour');
                $comment->setAuthor($this->getUser());
                $comment->setArticle($article);
                
                
                $manager->persist($comment);
                $manager->flush(); 
                
            }
            
        return $this->render('blog/article.html.twig', [
            'articles' => $article,
            'form' => $form->createView()
        ]);
    }

        /**
         * @Route("/categorie/pc/{page}", name="categorie_pc", requirements={"page": "\d+"})
         */
        public function categoriePc(ArticleRepository $repo, $page = 1)
        {
            $limit = 10;
            $start = $page * $limit - $limit;
            
            $total = count($repo->findBy(['categorie' => 'pc']));
            $pages = ceil($total / $limit); // 3.4 => 4
            
            $coucou = new Article();
            $article = $repo->findBy(['categorie' => 'pc'], ['dateTimePublication' => 'DESC'], $limit, $start);
            
            return $this->render('blog/categories/categorie_pc.html.twig', [
                'articles' => $article,
                'pages' => $pages,
                'page' => $page
            ]);
        }

        /**
         * @Route("/categorie/ps4/{page}", name="categorie_ps4", requirements={"page": "\d+"})
         */
        public function categoriePs4(ArticleRepository $repo, $page = 1)
        {
            $limit = 10;
            $start = $page * $limit - $limit;
            
            $total = count($repo->findBy(['categorie' => 'ps4']));
            $pages = ceil($total / $limit); // 3.4 => 4
            
            $coucou = new Article();
            $article = $repo->findBy(['categorie' => 'ps4'], ['dateTimePublication' => 'DESC'], $limit, $start);
            
            return $this->render('blog/categories/categorie_ps4.html.twig', [
                'articles' => $article,
                'pages' => $pages,
                'page' => $page
            ]);
        }

        /**
         * @Route("/categorie/xbox/{page}", name="categorie_xbox", requirements={"page": "\d+"})
         */
        public function categorieXbox(ArticleRepository $repo, $page = 1)
        {
            $limit = 10;
            $start = $page * $limit - $limit;
            
            $total = count($repo->findBy(['categorie' => 'xbox']));
            $pages = ceil($total / $limit); // 3.4 => 4
            
            $coucou = new Article();
            $article = $repo->findBy(['categorie' => 'xbox'], ['dateTimePublication' => 'DESC'], $limit, $start);
            
            return $this->render('blog/categories/categorie_xbox.html.twig', [
                'articles' => $article,
                'pages' => $pages,
                'page' => $page
            ]);
        }

        /**
         * @Route("/categorie/nintendo/{page}", name="categorie_nintendo", requirements={"page": "\d+"})
         */
        public function categorieNintendo(ArticleRepository $repo, $page = 1)
        {
            $limit = 10;
            $start = $page * $limit - $limit;
            
            $total = count($repo->findBy(['categorie' => 'nintendo']));
            $pages = ceil($total / $limit); // 3.4 => 4
            
            $coucou = new Article();
            $article = $repo->findBy(['categorie' => 'nintendo'], ['dateTimePublication' => 'DESC'], $limit, $start);
            
            return $this->render('blog/categories/categorie_nintendo.html.twig', [
                'articles' => $article,
                'pages' => $pages,
                'page' => $page
            ]);
        }

    /**
     * @Route("/compte", name="account")
     */
    public function profile(){
        return $this->render('blog/profile.html.twig', [
            'membre' => $this->getUser()
        ]);
    }
    
    /**
     * @Route("/compte/profil", name="profile_update")
     */
    public function profileUpdate (Request $request, ObjectManager $manager){
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);
            if($user -> getFile() != NULL)
            {
                $user -> removePicture();
                $user -> uploadPicture();
            }
            $manager->flush(); 

            $this->addFlash(
                'success',
                "Les changements ont bien été enregistrés !"
            );
        }

        return $this->render('blog/profile_update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/modification-mdp", name="password_update")
     */
    public function passwordUpdate(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){

        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // 1. Vérifier que le oldPassword du formulaire soit le même que le password de l'utilisateur
            if(empty($passwordUpdate->getOldPassword())){
                // Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Veuillez indiquer votre mot de passe actuel"));
            } else if(!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())){
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été modifié !'
                );

            }

        }
        
        return $this->render('blog/password.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
