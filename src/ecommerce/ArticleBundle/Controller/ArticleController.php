<?php

// src/ecommerce/ArticleBundle/Controller/ArticleController.php

namespace ecommerce\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller {

    public function categorieAction() {
        return $this->render('ecommerceArticleBundle:Article:categorie.html.twig');
    }

    public function detailAction() {
        return $this->render('ecommerceArticleBundle:Article:detail.html.twig');
    }

}
