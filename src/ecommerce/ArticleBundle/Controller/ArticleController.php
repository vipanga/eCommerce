<?php

// src/ecommerce/ArticleBundle/Controller/ArticleController.php

namespace ecommerce\ArticleBundle\Controller;

//namespace ecommerce\UserBundle\Controller;

use ecommerce\ArticleBundle\Entity\Category;
use ecommerce\ArticleBundle\Entity\Comment;
use ecommerce\ArticleBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ecommerce\ArticleBundle\Entity\Article;
use ecommerce\ArticleBundle\Entity\Genre;
use ecommerce\ArticleBundle\Entity\Search;
use ecommerce\UserBundle\Entity\User;
use ecommerce\ArticleBundle\Form\ArticleType;
use ecommerce\ArticleBundle\Form\CommentType;
use ecommerce\ArticleBundle\Form\ReviewType;
use ecommerce\ArticleBundle\Form\SearchType;

class ArticleController extends Controller
{
    /*
     * Affichage de tous les articles selon la catégorie sélectionnée
     *
     * */
    public function categoryAction(Category $category, $numberItemsPerPage, $page)
    {
        if ($category == null) {
            return $this->redirect($this->generateUrl('ecommerce_accueil_error404'));
        }

        // Sélection des articles de la catégorie sélectionnée
        $articles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Article')
            ->getArticlesByCategory($numberItemsPerPage, $page, $category);

        $categories = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Category')
            ->getCategories();

        return $this->render('ecommerceArticleBundle:Article:category.html.twig', array(
            'articles' => $articles,
            'category' => $category,
            'categories' => $categories,
            'page' => $page,
            'numberItemsPerPage' => $numberItemsPerPage,
            'nombrePage' => ceil(count($articles) / $numberItemsPerPage)
        ));
    }

    /*
     * Affichage de tous les articles selon le genre sélectionné
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

        $categories = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Category')
            ->getCategories();

        return $this->render('ecommerceArticleBundle:Article:genre.html.twig', array(
            'articles' => $articles,
            'genre' => $genre,
            'categories' => $categories,
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
                $comment->setAuthor($author);
                $comment->setArticle($article);
                // On enregistre notre objet $comment dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Commentaire bien ajouté');

                // On redirige vers la page de visualisation de l'article où on vient de commenter
                return $this->redirect($this->generateUrl('ecommerce_article_detail', array('id' => $article->getId(), 'slug' => $article->getSlug())));
            }
        }

        // On récupère ici tous les commentaires de l'article
        $comments = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Comment')
            ->getProductComments($article);

        $categories = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Category')
            ->getCategories();

        return $this->render('ecommerceArticleBundle:Article:detail.html.twig',
            array(
                'article' => $article,
                'note' => $note,
                'comments' => $comments,
                'categories' => $categories,
                'form' => $form->createView()
            )
        );
    }

    /*
     * Fonction de recherche d'un article
     *
     * */
    public function searchAction($numberItemsPerPage, $page, $product, $province)
    {
        $search = new Search();

        // On crée le formulaire grâce à l'SearchType
        $form = $this->createForm(new SearchType(), $search);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                // On enregistre notre objet $search dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($search);
                $em->flush();

                $product = $search->getProduct();
                $province = $search->getProvince();

                if (($province == 'Toutes') || ($province == "")) {
                    // Sélection des articles de la catégorie sélectionnée
                    $articles = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ecommerceArticleBundle:Article')
                        ->getSearchArticlesOnly($numberItemsPerPage, $page, $product);
                } else {
                    // Sélection des articles de la catégorie sélectionnée
                    $articles = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ecommerceArticleBundle:Article')
                        ->getSearchArticles($numberItemsPerPage, $page, $product, $province);
                }


                return $this->render('ecommerceArticleBundle:Article:search.html.twig', array(
                    'articles' => $articles,
                    'product' => $product,
                    'province' => $province,
                    'page' => $page,
                    'numberItemsPerPage' => $numberItemsPerPage,
                    'nombrePage' => ceil(count($articles) / $numberItemsPerPage)
                ));
            }
        }

        if (($province == 'Toutes') || ($province == "")) {
            // Sélection des articles de la catégorie sélectionnée
            $articles = $this->getDoctrine()
                ->getManager()
                ->getRepository('ecommerceArticleBundle:Article')
                ->getSearchArticlesOnly($numberItemsPerPage, $page, $product);
        } else {
            // Sélection des articles de la catégorie sélectionnée
            $articles = $this->getDoctrine()
                ->getManager()
                ->getRepository('ecommerceArticleBundle:Article')
                ->getSearchArticles($numberItemsPerPage, $page, $product, $province);
        }

        return $this->render('ecommerceArticleBundle:Article:search.html.twig', array(
            'articles' => $articles,
            'product' => $product,
            'province' => $province,
            'page' => $page,
            'numberItemsPerPage' => $numberItemsPerPage,
            'nombrePage' => ceil(count($articles) / $numberItemsPerPage)
        ));
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

        $review = new Review();
        // On crée le formulaire grâce à ReviewType
        $form = $this->createForm(new ReviewType(), $review);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                $author = $this->getUser();
                $review->setUser($user);
                $review->setAuthor($author);
                // On enregistre notre objet $review dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($review);
                $em->flush();

                // On calcul la moyenne des notes du vendeur et on l'enregistre dans la base de données
                $user->setNote($this->moyenneNote($user));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Avis bien ajouté');

                return $this->redirect($this->generateUrl('ecommerce_article_publisher_items',
                    array(
                        'id' => $user->getId(),
                        'username' => $user->getUsername()
                    )
                ));
            }
        }

        // On récupère ici toutes les notes sur le vendeur
        $reviews = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Review')
            ->getUserReviews($user);

        return $this->render('ecommerceArticleBundle:Article:publisher_items.html.twig', array(
            'articles' => $articles,
            'page' => $page,
            'user' => $user,
            'numberItemsPerPage' => $numberItemsPerPage,
            'nombrePage' => ceil(count($articles) / $numberItemsPerPage),
            'reviews' => $reviews,
            'form' => $form->createView()
        ));
    }

    /*
     * Administration du stand du vendeur.
     * C'est à partir d'ici qu'on pourra lancer la modification
     * ou soit la suppression des articles publiés par le vendeur
     *
     * */

    function moyenneNote(User $user)
    {
        $reviews = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Review')
            ->getUserReviews($user);

        $resultat = 0;

        foreach ($reviews as $review) {
            $resultat = $resultat + $review->getNote();
        }

        $total = count($reviews);
        if ($total <= 0) {
            $total = 1;
        }

        $moyenne = $resultat / $total;

        return $moyenne;
    }

    /*
     * C'est ici qu'on pourra modifier l'article publié par le vendeur
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
     * C'est ici qu'on pourra supprimer l'article publié par le vendeur
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
     * Cette fonction fait des calculs et renvoie la moyenne des notes pour
     * l'utilisateur passé en paramètre
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

    public function searchFormAction()
    {
        $search = new Search();

        // On crée le formulaire grâce à l'SearchType
        $form = $this->createForm(new SearchType(), $search);

        return $this->render('ecommerceArticleBundle:Article:search_form.html.twig', array('form' => $form->createView()));
    }

}
