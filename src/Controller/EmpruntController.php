<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\Utilisateur;
use App\Service\EmpruntService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class EmpruntController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/oeuvre/{id}/reserver', name: 'app_reservation', methods:['POST'])]
    public function reserver(Request $request, Oeuvre $oeuvre, EmpruntService $empruntService): Response
    {
        // vérifier le token
        if (!$this->isCsrfTokenValid(
            'reserver_' . $oeuvre->getId(),
            $request->request->get('_token')
        )) {
            $this->addFlash('error', 'Jeton de sécurité invalide');
            return $this->redirectToRoute('app_oeuvre');
        }

        // récuperer l'utilisateur connecté
        $utilisateur = $this->getUser();
        if (!$utilisateur instanceof Utilisateur) {
            throw $this->createAccessDeniedException();
        }

        try {
            $emprunt = $empruntService->reserverOeuvre(
                $utilisateur,
                $oeuvre
            );
               // $this->addFlash('success', 'Réservation confirmée');
            $this->addFlash('success', sprintf(
                'Réservation confirmée (exemplaire %s) ! Valable 7 jours (jusqu\'au %s).',
                $emprunt->getExemplaire()->getCodeInventaire(),
                $emprunt->getDateReservation()->modify('+7 days')->format('d/m/Y')

            ));
        } catch(\RuntimeException $e){
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app_oeuvre');
    }
}
