<?php
// src/Controller/DeconnexionController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeconnexionController extends AbstractController
{
    #[Route('/deconnexion', name: 'deconnexion')]
    public function deconnexion(Request $request): Response
    {
        // Récupérer la session à partir de la requête
        $session = $request->getSession();
        
        // Détruire la session
        $session->invalidate();
        
        // Rediriger vers la page d'accueil ou une autre page
        return $this->redirectToRoute('connexion');
    }
}
