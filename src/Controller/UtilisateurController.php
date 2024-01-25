<?php

// src/Controller/UtilisateurController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;


class UtilisateurController extends AbstractController
{
    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(Request $request): Response
    {
        // Crée le formulaire de connexion
        $form = $this->createForm(ConnexionType::class);

        // Gère la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, tu peux traiter la connexion, par exemple en utilisant le composant Security de Symfony
            // ...

            // Redirige après la connexion
            return $this->redirectToRoute('accueil');
        }

        // Affiche la page de connexion avec le formulaire
        return $this->render('utilisateur/connexion.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request): Response
    {
        // Crée une nouvelle instance de l'entité Utilisateur
        $utilisateur = new Utilisateur();

        // Crée le formulaire d'inscription en l'associant à l'entité Utilisateur
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        // Gère la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encodage du mot de passe (tu devras utiliser le composant de sécurité de Symfony ici)
            $encodedPassword = password_hash($utilisateur->getPassword(), PASSWORD_BCRYPT);
            $utilisateur->setPassword($encodedPassword);

            // Enregistre l'utilisateur dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            // Redirige après l'inscription
            return $this->redirectToRoute('accueil');
        }

        // Affiche la page d'inscription avec le formulaire
        return $this->render('utilisateur/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte", name="compte_utilisateur")
     */
    public function compteUtilisateur(): Response
    {
        // Ton code pour afficher le compte utilisateur
        return $this->render('utilisateur/compte.html.twig');
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(): Response
    {
        // Ton code pour gérer la déconnexion
        // Par exemple : $this->get('security.token_storage')->setToken(null);
        return $this->redirectToRoute('accueil'); // Redirige vers la page d'accueil
    }
}
