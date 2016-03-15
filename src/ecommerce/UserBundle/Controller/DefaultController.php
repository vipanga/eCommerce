<?php

namespace ecommerce\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ecommerceUserBundle:Default:index.html.twig');
    }
}
