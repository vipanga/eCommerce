<?php

namespace ecommerce\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('ecommerceUserBundle:Default:index.html.twig');
    }
    
    public function section_profileAction() {
        return $this->render('ecommerceUserBundle:Registration:customer_section.html.twig');
    }
}