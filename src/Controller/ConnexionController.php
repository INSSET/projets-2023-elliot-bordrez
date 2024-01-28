<?php
// src/Controller/ConnexionController.php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ConnexionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;

class ConnexionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/connexion', name: 'connexion')]
    public function connexion(Request $request): Response
    {
        $form = $this->createForm(ConnexionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupére les données du formulaire
            $formData = $form->getData();

            // Récupére l'utilisateur en fonction du pseudo
            $user = $this->entityManager->getRepository(Utilisateur::class)->findOneBy([
                'pseudo' => $formData['pseudo'],
            ]);

            if (!$user) {
                throw new BadCredentialsException('Invalid pseudo');
            }

            // Rediriger vers la page d'accueil après la connexion réussie
            return $this->redirectToRoute('accueil');
        }

        return $this->render('utilisateur/connexion.html.twig', [
            'ConnexionForm' => $form->createView(),
        ]);
    }
}
