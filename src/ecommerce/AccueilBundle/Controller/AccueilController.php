<?php

// src/ecommerce/AccueilBundle/Controller/AccueilController.php

namespace ecommerce\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller {

    public function indexAction() {
        $genres = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Genre')
            ->getGenres();
        return $this->render('ecommerceAccueilBundle:Accueil:index.html.twig', array('genres' => $genres));
    }

    public function menuAction() {
        $categories = $this->getDoctrine()
                ->getManager()
                ->getRepository('ecommerceArticleBundle:Category')
                ->getCategories();
        
        return $this->render('ecommerceAccueilBundle:Accueil:menu.html.twig', array( 'categories' => $categories ));
    }
    
    public function contactAction() {
        return $this->render('ecommerceAccueilBundle:Accueil:contact.html.twig');
    }
    
    public function inscriptionAction() {
        return $this->render('ecommerceAccueilBundle:Accueil:inscription.html.twig');
    }
    
    public function publicationsAction() {
        return $this->render('ecommerceAccueilBundle:Accueil:publications.html.twig');
    }
    
    public function categorieAction() {
        return $this->render('ecommerceAccueilBundle:Accueil:categorie.html.twig');
    }
    
    public function error404Action() {
        return $this->render('ecommerceAccueilBundle:Accueil:404.html.twig');
    }

}
