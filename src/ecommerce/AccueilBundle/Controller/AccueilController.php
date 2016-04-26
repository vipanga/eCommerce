<?php

// src/ecommerce/AccueilBundle/Controller/AccueilController.php

namespace ecommerce\AccueilBundle\Controller;

use ecommerce\AccueilBundle\Entity\Message;
use ecommerce\AccueilBundle\Form\MessageType;
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
        $message = new Message();
        // On crée le formulaire grâce à CommentType
        $form = $this->createForm(new MessageType(), $message);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                // On enregistre notre objet $comment dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();


                //On pourrait envoyer ici une notification à l'utilisateur.
                $mailer = $this->get('mailer');

                $message = \Swift_Message::newInstance()
                    ->setSubject($message->getSubject())
                    ->setFrom($message->getEmail())
                    ->setTo('ipanga@outlook.fr')
                    ->setBody('Envoyé par :' . $message->getName() . ' Email:' . $message->getEmail() . ' Message: ' . $message->getContent());
                $mailer->send($message);

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Votre message a bien été envoyé');

                // On redirige vers la page de visualisation de l'article modifié
                return $this->redirect($this->generateUrl('ecommerce_accueil_contact'));
            }
        }

        return $this->render('ecommerceAccueilBundle:Accueil:contact.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function error404Action() {
        return $this->render('ecommerceAccueilBundle:Accueil:404.html.twig');
    }

}