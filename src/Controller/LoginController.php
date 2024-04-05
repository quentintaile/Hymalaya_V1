<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error= $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername,
        ]);
    }

    #[Route('/deconnexion', name: 'app_logout', methods : ['GET'])]
    public function logout(): never
    {
        throw new Exception( 'ne pas oublier de mettre');
    }
}
