<?php

// src/ecommerce/ArticleBundle/Controller/ArticleController.php

namespace ecommerce\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ecommerce\ArticleBundle\Entity\Article;
use ecommerce\ArticleBundle\Entity\Genre;
use ecommerce\ArticleBundle\Entity\Image;
use ecommerce\ArticleBundle\Form\ArticleType;
use ecommerce\ArticleBundle\Form\ImageType;

class ArticleController extends Controller {

    public function genreAction(Genre $genre) {
        if($genre == null)
        {
            return $this->redirect($this->generateUrl('ecommerce_accueil_erreur404'));
        }
        return $this->render('ecommerceArticleBundle:Article:genre.html.twig', array('genre' => $genre));
    }

    public function createAction() {
        /* PREMIERE METHODE, DEUXIEME METHODE ANNOTATIONS // On teste que l'utilisateur dispose bien du rôle ROLE_AUTEUR
          if (!$this->get('security.context')->isGranted('ROLE_AUTEUR')) {
          // Sinon on déclenche une exception « Accès interdit »
          throw new AccessDeniedHttpException('Accès limité aux auteurs');
          } */

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
                return $this->redirect($this->generateUrl('ecommerce_article_detail', array('id' => $article->getId())));
            }
        }

        return $this->render('ecommerceArticleBundle:Article:create.html.twig', array('form' => $form->createView(),));
    }

    public function detailAction(Article $article) {
        
        if($article == null)
        {
            return $this->redirect($this->generateUrl('ecommerce_accueil_erreur404'));
        }
        return $this->render('ecommerceArticleBundle:Article:detail.html.twig', array('article' => $article));
    }

}
