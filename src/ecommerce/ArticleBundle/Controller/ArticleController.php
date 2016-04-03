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

    /*
     * Affichage de tous les articles selon la catégorie sélectionnée
     *
     * */
    public function genreAction(Genre $genre, $numberItemsPerPage, $page)
    {
        if ($genre == null) {
            return $this->redirect($this->generateUrl('ecommerce_accueil_error404'));
        }

        // Sélection des articles de la catégorie sélectionnée
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

    /*
     * Formulaire pour la création d'un article
     *
     * */
    public function createAction()
    {
        // On vérifie si l'utilisateur est connecté, sinon on le redirige sur le formulaire de connection
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

    /*
     * Affichage des détails de l'article sélectionné
     *
     * */
    public function detailAction(Article $article)
    {
        $user = $article->getUser();
        $note = $user->getNote();

        if ($article == null) {
            return $this->redirect($this->generateUrl('ecommerce_accueil_error404'));
        }
        return $this->render('ecommerceArticleBundle:Article:detail.html.twig', array('article' => $article, 'note' => $note));
    }

    /*
     * Affichage de tous les articles du Stand du vendeur
     *
     * */
    public function publisherItemsAction(User $user, $numberItemsPerPage, $page)
    {
        // On récupère tous les articles du stand du vendeur
        $articles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Article')
            ->getUserArticles($numberItemsPerPage, $page, $user);

        $comment = new Comment();
        // On crée le formulaire grâce à CommentType
        $form = $this->createForm(new CommentType(), $comment);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                $author = $this->getUser();
                $comment->setUser($user);
                $comment->setAuthor($author);
                // On enregistre notre objet $comment dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                // On calcul la moyenne des notes du vendeur et on l'enregistre dans la base de données
                $user->setNote($this->moyenneNote($user));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Commentaire bien ajouté');

                return $this->redirect($this->generateUrl('ecommerce_article_publisher_items',
                    array(
                        'id' => $user->getId(),
                        'username' => $user->getUsername()
                    )
                ));
            }
        }

        // On récupère ici tous les commentaires sur le vendeur
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

    /*
     * Administration du stand du vendeur.
     * C'est à partir d'ici qu'on pourra lancer la modification
     * ou soit la suppression des articles publiés par le vendeur
     *
     * */
    public function publicationsAction($page, $numberItemsPerPage)
    {
        // On vérifie si l'utilisateur est connecté, sinon on le redirige sur le formulaire de connection
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

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

    /*
     * C'est ici qu'on pourra modifier l'article publié par le vendeur
     *
     * */
    public function editAction(Article $article)
    {
        $user1 = $this->getUser();
        $user2 = $article->getUser();

        // On vérifie si l'utilisateur est connecté, sinon on le redirige sur le formulaire de connection
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        // On vérifie si l'utilisateur n'essaie pas de modifier un article qui ne lui appartient pas
        // Si c'est le cas, on va le rediriger sur une page d'erreur
        elseif ($user1->getId() != $user2->getId()){
            // On redirige vers la page de visualisation de l'article modifié
            return $this->redirect($this->generateUrl('ecommerce_accueil_error404'));
        }

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

    /*
     * C'est ici qu'on pourra supprimer l'article publié par le vendeur
     *
     * */
    public function deleteAction(Article $article)
    {
        $user1 = $this->getUser();
        $user2 = $article->getUser();

        // On vérifie si l'utilisateur est connecté, sinon on le redirige sur le formulaire de connection
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        // On vérifie si l'utilisateur n'essaie pas de supprimer un article qui ne lui appartient pas
        // Si c'est le cas, on va le rediriger sur une page d'erreur
        elseif ($user1->getId() != $user2->getId()){
            // On redirige vers la page de visualisation de l'article modifié
            return $this->redirect($this->generateUrl('ecommerce_accueil_error404'));
        }

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

    /*
     * Cette fonction fait des calculs et renvoie la moyenne des notes pour
     * l'utilisateur passé en paramètre
     *
     * */
    function moyenneNote(User $user)
    {
        $comments = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Comment')
            ->getUserComments($user);

        $resultat = 0;

        foreach ($comments as $comment) {
            $resultat = $resultat + $comment->getNote();
        }

        $total = count($comments);
        if ($total <= 0) {
            $total = 1;
        }

        $moyenne = $resultat / $total;

        return $moyenne;
    }

}
