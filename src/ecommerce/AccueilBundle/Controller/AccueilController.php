<?php

// src/ecommerce/AccueilBundle/Controller/AccueilController.php

namespace ecommerce\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller {

    public function indexAction() {
        return $this->render('ecommerceAccueilBundle:Accueil:index.html.twig');
    }

    public function menuAction() {
        return $this->render('ecommerceAccueilBundle:Accueil:menu.html.twig');
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

}
