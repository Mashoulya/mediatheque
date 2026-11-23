<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class EnregistrementController extends AbstractController
{
    #[Route('/enregistrement', name: 'app_enregistrement')]
    public function enregistrement(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        // on vérifie si la méthode est bien POST et on récupère les données saisies dans les champs
        if ($request->isMethod('POST')) {
            $email = trim($request->request->get('email'));
            $mdp = trim($request->request->get('mdp'));
            $nom = trim($request->request->get('nom'));
            $prenom = trim($request->request->get('prenom'));

            // vérifier token csrf
        if (!$this->isCsrfTokenValid(
            'register',
            $request->request->get('_csrf_token')
        )) {
            throw $this->createAccessDeniedExeption('Token CSRF invalide');
        }

            // vérifier les champs
            if ($email === '' || $mdp === '' || $nom === '' || $prenom === '') {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('app_enregistrement');
            }

            // vérifier si l'email existe dans la bdd
            $existingUser = $em
                ->getRepository(Utilisateur::class)
                ->findOneBy(['email' => $email]);

            // si l'utilisateur existe on crée un msg d'erreur
            if ($existingUser) {
                $this->addFlash('error', 'Cette adresse email est déjà utilisée.');
                return $this->redirectToRoute('app_enregistrement');
            }

            // créer un nouvel utilisateur
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($nom);
            $utilisateur->setPrenom($prenom);
            $utilisateur->setEmail($email);
            $mdpHashe = $passwordHasher->hashPassword(
                $utilisateur,
                $mdp
            );
            $utilisateur->setMdp($mdpHashe);
            $utilisateur->setDateCreation(new \DateTimeImmutable());
            $utilisateur->setDateModification(new \DateTimeImmutable());
            $utilisateur->setRoles(['ROLE_USER']);

            // enregistrer le nouvel utiulisateur dans la bdd
            $em->persist($utilisateur);
            $em->flush();

            $this->addFlash('success', 'Votre compte a été créé.');

            return $this->redirectToRoute('app_connexion');
        }

         return $this->render('enregistrement/enregistrement.html.twig');
    }
}
