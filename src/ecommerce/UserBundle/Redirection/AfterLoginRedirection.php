<?php
/**
 * Created by PhpStorm.
 * User: Valery.Ipanga
 * Date: 07/Apr/16
 * Time: 2:29 PM
 */

namespace ecommerce\UserBundle\Redirection;

use ecommerce\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // On récupère la liste des rôles d'un utilisateur
        $user = $token->getUser();

        $redirection = new RedirectResponse($this->router->generate('ecommerce_article_publisher_items',
            array(
                'id' => $user->getId(),
                'username' => $user->getUsername()
            )
        ));

        return $redirection;
    }
}