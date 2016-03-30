<?php

// src/ecommerce/ArticleBundle/Controller/ArticleController.php

namespace ecommerce\ArticleBundle\Controller;

//namespace ecommerce\UserBundle\Controller;

use ecommerce\ArticleBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ecommerce\ArticleBundle\Entity\Article;
use ecommerce\ArticleBundle\Entity\Genre;
use ecommerce\UserBundle\Entity\User;
use ecommerce\ArticleBundle\Form\ArticleType;
use ecommerce\ArticleBundle\Form\CommentType;

class ArticleController extends Controller
{

    public function genreAction(Genre $genre, $numberItemsPerPage, $page)
    {
        if ($genre == null) {
            return $this->redirect($this->generateUrl('ecommerce_accueil_erreur404'));
        }

        $articles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Article')
            ->getArticles($numberItemsPerPage, $page, $genre);

        return $this->render('ecommerceArticleBundle:Article:genre.html.twig', array(
            'articles' => $articles,
            'genre' => $genre,
            'page' => $page,
            'numberItemsPerPage' => $numberItemsPerPage,
            'nombrePage' => ceil(count($articles) / $numberItemsPerPage)
        ));
    }

    public function createAction()
    {
        // yay! Use this to see if the user is logged in
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        $article = new Article;

        // On crée le formulaire grâce à l'ArticleType
        $form = $this->createForm(new ArticleType(), $article);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {
                $user = $this->getUser();
                $article->setUser($user);
                // On enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Article bien ajouté');

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('ecommerce_article_detail', array('id' => $article->getId(), 'slug' => $article->getSlug())));
            }
        }

        return $this->render('ecommerceArticleBundle:Article:create.html.twig', array('form' => $form->createView(),));
    }

    public function detailAction(Article $article)
    {

        if ($article == null) {
            return $this->redirect($this->generateUrl('ecommerce_accueil_erreur404'));
        }
        return $this->render('ecommerceArticleBundle:Article:detail.html.twig', array('article' => $article));
    }

    public function publicationsAction($page, $numberItemsPerPage)
    {
        $user = $this->getUser();
        $articles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Article')
            ->getUserArticles($numberItemsPerPage, $page, $user);

        return $this->render('ecommerceArticleBundle:Article:publications.html.twig', array(
            'articles' => $articles,
            'page' => $page,
            'numberItemsPerPage' => $numberItemsPerPage,
            'nombrePage' => ceil(count($articles) / $numberItemsPerPage)
        ));
    }

    public function publisherItemsAction(User $user, $numberItemsPerPage, $page)
    {
        $articles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Article')
            ->getUserArticles($numberItemsPerPage, $page, $user);

        $comment = new Comment();
        // On crée le formulaire grâce à l'ArticleType
        $form = $this->createForm(new CommentType(), $comment);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {
                $author = $this->getUser();
                $comment->setUser($user);
                $comment->setAuthor($author);
                // On enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Commentaire bien ajouté');

                return $this->redirect($this->generateUrl('ecommerce_article_publisher_items', array('id' => $user->getId())));
            }
            return $this->redirect($this->generateUrl('ecommerce_accueil_error404'));
        }

        $comments = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Comment')
            ->getUserComments($user);

        return $this->render('ecommerceArticleBundle:Article:publisher_items.html.twig', array(
            'articles' => $articles,
            'page' => $page,
            'user' => $user,
            'numberItemsPerPage' => $numberItemsPerPage,
            'nombrePage' => ceil(count($articles) / $numberItemsPerPage),
            'comments' => $comments,
            'form' => $form->createView()
        ));
    }

    public function editAction(Article $article)
    {
        // On utiliser le ArticleEditType
        $form = $this->createForm(new ArticleType(), $article);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre l'article
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Article bien modifié');

                // On redirige vers la page de visualisation de l'article modifié
                return $this->redirect($this->generateUrl('ecommerce_article_detail', array('id' => $article->getId(), 'slug' => $article->getSlug())));
            }
        }

        return $this->render('ecommerceArticleBundle:Article:edit.html.twig', array(
            'form' => $form->createView(),
            'article' => $article
        ));
    }

    public function deleteAction(Article $article)
    {
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'article contre cette faille
        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On supprime l'article
                $em = $this->getDoctrine()->getManager();
                $em->remove($article);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Article bien supprimé');

                // Puis on redirige vers l'accueil
                return $this->redirect($this->generateUrl('ecommerce_article_publications'));
            }
        }

        // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
        return $this->render('ecommerceArticleBundle:Article:delete.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }

}
