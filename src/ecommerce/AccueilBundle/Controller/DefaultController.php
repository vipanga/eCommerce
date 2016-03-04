<?php

namespace ecommerce\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ecommerceAccueilBundle:Default:index.html.twig');
    }
}
