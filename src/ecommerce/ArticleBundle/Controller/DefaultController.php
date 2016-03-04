<?php

namespace ecommerce\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ecommerceArticleBundle:Default:index.html.twig');
    }
}
