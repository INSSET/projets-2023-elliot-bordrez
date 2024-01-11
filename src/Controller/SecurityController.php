<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends AbstractController
{
    public function login(Request $request, Security $security)
    {
        // Gérer la connexion ici
    }

    public function logout()
    {
        // Gérer la déconnexion ici
    }
}
