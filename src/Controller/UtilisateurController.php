<?php
// src/Controller/UtilisateurController.php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UtilisateurController extends AbstractController
{
    private $entityManager;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $request): Response
    {
        $form = $this->createForm(InscriptionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Je crée une instance de l'entité Utilisateur à partir des données du formulaire
            $user = new Utilisateur();
            $user->setEmail($form->get('email')->getData());
            $user->setPseudo($form->get('pseudo')->getData());
            $user->setAge($form->get('age')->getData());

            // Entité
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Redirige après l'inscription réussie
            return $this->redirectToRoute('inscription');
        }

        return $this->render('utilisateur/inscription.html.twig', [
            'InscriptionForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(): Response
    {
        // Déconnecte l'utilisateur en supprimant le token d'authentification
        $this->tokenStorage->setToken(null);

        // Redirige l'utilisateur vers la page d'accueil après la déconnexion
        return $this->redirectToRoute('inscription');
    }
}
