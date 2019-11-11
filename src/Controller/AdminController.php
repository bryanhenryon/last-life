<?php

namespace App\Controller;

use DateTimeZone;
use App\Entity\Membre;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/index/{page}", name="index_admin", requirements={"page": "\d+"})
     */
    public function index($page = 1)
    {
        $repo = $this->getDoctrine()->getRepository(Membre::class);

        $limit = 10;
        $start = $page * $limit - $limit;
        $total = count($repo->findAll());
        $pages = ceil($total / $limit); 

        $coucou = new Membre();
        $membres = $repo->findBy([], ['dateTimeRegistry' => 'DESC'], $limit, $start);
        // Le premier paramètre est OU, et le second est DANS QUEL ORDRE

        return $this->render('admin/index.html.twig', [
            'membres' => $membres,
            'pages' => $pages,
            'page' => $page
        ]);
    }

    /**
     * @Route("/admin/index_delete/{id}", name="index_delete")
     */
    public function membres_delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $membre = $em->find(Membre::class, $id);

        $em->remove($membre);
        $em->flush();

        $this->addFlash(
            'success',
            'Le membre a bien été supprimé'
        );
        return $this->redirectToRoute('index_admin');
    }

    /**
     * @Route("/admin/articles/{page}", name="articles_admin", requirements={"page": "\d+"})
     */
    public function articles($page = 1)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $limit = 10;
        $start = $page * $limit - $limit;
        $total = count($repo->findAll());
        $pages = ceil($total / $limit); 

        

        $coucou = new Article();
        $articles = $repo->findBy([], ['dateTimePublication' => 'DESC'], $limit, $start);

        return $this->render('admin/articles.html.twig', [
            'articles' => $articles,
            'pages' => $pages,
            'page' => $page
        ]);
    }

    /**
     * @Route("/admin/articles_add", name="articles_add")
     */
    public function articles_add(Request $Request)
    {


        $article = new Article();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($Request);


        if ($form->isSubmitted() && $form->isValid()) {
            $article -> setDateTimePublication($datetime = new \DateTime('now',new \DateTimeZone('UTC')));
            $datetime->modify('+1 hour');
            $em->persist($article);
            $article ->uploadImagePreview();
            $article -> uploadFirstImage();
            $article -> uploadSecondImage();
            $article -> setAuthor($this->getUser());
            $em->flush();

            $this->addFlash(
                'success',
                'L\'article n°' . $article->getId() . ' a bien été publié'
            );

            return $this->redirectToRoute('articles_admin');
        }


        return $this->render('admin/articles_add.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/articles_delete/{id}", name="articles_delete")
     */
    public function articles_delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->find(Article::class, $id);

        $em->remove($article);
        $article->removePhoto();
        $article->removeFirstImage();
        $article->removeSecondImage();

        $em->flush();

        $this->addFlash(
            'success',
            'L\'article a bien été supprimé'
        );

        return $this->redirectToRoute('articles_admin');
    }

    /**
     * @Route("/admin/articles_update/{id}", name="articles_update")
     */
    public function articles_update(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $article = $em->find(Article::class, $id);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            if($article -> getFile() != NULL)
            {
                $article -> removePhoto();
                $article -> removeFirstImage();
                $article -> removeSecondImage();
                $article -> uploadImagePreview();
                $article -> uploadFirstImage();
                $article -> uploadSecondImage();
            }
            $em->flush();

            $this->addFlash(
                'success',
                'L\'article n°' . $article->getId() . ' a bien été modifié'
            );
            return $this->redirectToRoute('articles_admin');
        }


        return $this->render(
            'admin/articles_add.html.twig',

            [
                'formArticle' => $form->createView(),

            ]
        );
    }

    /**
     * @Route("/admin/comments_admin{page}", name="comments_admin", requirements={"page": "\d+"})
     */
    public function comments($page = 1){
        $repo = $this->getDoctrine()->getRepository(Comment::class);

        $limit = 10;
        $start = $page * $limit - $limit;
        $total = count($repo->findAll());
        $pages = ceil($total / $limit);

        $comments = $repo->findBy([], ['createdAt' => 'DESC'], $limit, $start);

        return $this->render('admin/comments.html.twig', [
            'comments' => $comments,
            'pages' => $pages,
            'page' => $page
        ]);
    }

    /**
     * @Route("/admin/comment_delete/{id}", name="comment_delete")
     */
    public function comment_delete($id){
        $em = $this->getDoctrine()->getManager();
        $comment = $em->find(Comment::class, $id);

        $em->remove($comment);
        $em->flush();

        $this->addFlash(
            'success',
            'Le commentaire a bien été supprimé'
        );
        return $this->redirectToRoute('comments_admin');
    }

}
