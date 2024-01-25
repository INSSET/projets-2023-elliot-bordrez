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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UtilisateurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(Request $request): Response
    {
        $form = $this->createForm(ConnexionType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Faites quelque chose ici, par exemple, vérifier les informations d'authentification
        }

        return $this->render('utilisateur/connexion.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(InscriptionType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $form->getData();

            $password = $passwordEncoder->encodePassword($utilisateur, $utilisateur->getPlainPassword());
            $utilisateur->setPassword($password);

            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('utilisateur/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte", name="compte_utilisateur")
     */
    public function compteUtilisateur(): Response
    {
        return $this->render('utilisateur/compte.html.twig');
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(): Response
    {
        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/check_keys", name="check_keys")
     */
    public function checkKeys(): Response
    {
        $ewzRecaptchaSiteKey = $this->getParameter('ewz_recaptcha_site_key');

        return new Response(
            'EWZ reCAPTCHA Site Key: ' . $ewzRecaptchaSiteKey
        );
    }
}
