<?php
// src/Controller/RegistrationController.php

namespace App\Controller;

use App\Entity\Utilisateur; // Assurez-vous que cette ligne est présente
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $request): Response
    {
        $form = $this->createForm(InscriptionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Crée une instance de l'entité User à partir des données du formulaire
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
}