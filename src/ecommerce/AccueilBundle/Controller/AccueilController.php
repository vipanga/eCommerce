<?php

// src/ecommerce/AccueilBundle/Controller/AccueilController.php

namespace ecommerce\AccueilBundle\Controller;

use ecommerce\ArticleBundle\Entity\Search;
use ecommerce\ArticleBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller {

    public function indexAction() {

        return $this->render('ecommerceAccueilBundle:Accueil:index.html.twig');
    }

    public function menuAction() {

        $categories = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Category')
            ->getCategories();

        return $this->render('ecommerceAccueilBundle:Accueil:menu.html.twig', array('categories' => $categories));
    }

    public function headerAction()
    {
        // On vérifie si l'utilisateur est connecté, sinon on le redirige sur le formulaire de connection
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();
            return $this->render('ecommerceAccueilBundle:Accueil:header.html.twig', array('user' => $user));
        }
        return $this->render('ecommerceAccueilBundle:Accueil:header.html.twig');
    }

    public function contactAction() {
        return $this->render('ecommerceAccueilBundle:Accueil:contact.html.twig');
    }

    public function error404Action() {
        return $this->render('ecommerceAccueilBundle:Accueil:404.html.twig');
    }

}