<?php

// src/ecommerce/AccueilBundle/Controller/AccueilController.php

namespace ecommerce\AccueilBundle\Controller;

use ecommerce\ArticleBundle\Entity\Search;
use ecommerce\ArticleBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller {

    public function indexAction() {
        $listOfItems = array();
        $telephones = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Article')
            ->getTelephones();

        $listOfItems[] = $telephones;

        $televiseurs = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Article')
            ->getTeleviseurs();

        $listOfItems[] = $televiseurs;

        $materiaux = $this->getDoctrine()
            ->getManager()
            ->getRepository('ecommerceArticleBundle:Article')
            ->getMateriaux();

        $listOfItems[] = $materiaux;

        return $this->render('ecommerceAccueilBundle:Accueil:index.html.twig', array(
            'listOfItems' => $listOfItems,
            'break' => true
        ));

        /*return $this->render('ecommerceAccueilBundle:Accueil:index.html.twig', array(
            'telephones' => $telephones,
            'televiseurs' => $televiseurs,
            'materiaux' => $materiaux
        ));*/
    }

    public function menuAction() {
        $search = new Search();

        // On crée le formulaire grâce à l'SearchType
        $form = $this->createForm(new SearchType(), $search);

        $categories = $this->getDoctrine()
                ->getManager()
                ->getRepository('ecommerceArticleBundle:Category')
                ->getCategories();

        return $this->render('ecommerceAccueilBundle:Accueil:menu.html.twig', array('categories' => $categories, 'form' => $form->createView()));
    }
    
    public function contactAction() {
        $googlemap = true;
        return $this->render('ecommerceAccueilBundle:Accueil:contact.html.twig', array('googlemap' => $googlemap));
    }
    
    public function error404Action() {
        return $this->render('ecommerceAccueilBundle:Accueil:404.html.twig');
    }

}
