<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Oeuvre;
use App\Enum\StatutReservation;
use App\Repository\EmpruntRepository;
use App\Repository\ExemplaireRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class EmpruntController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/oeuvre/{id}/reserver', name: 'app_reservation', methods:['POST'])]
    public function reserver(Request $request, EntityManagerInterface $em, ExemplaireRepository $exemplaireRepository, Oeuvre $oeuvre, EmpruntRepository $empruntRepository): Response
    {

        // vérifier le token
        if (!$this->isCsrfTokenValid(
            'reserver_' . $oeuvre->getId(),
            $request->request->get('_token')
        )) {
            $this->addFlash('error', 'Jeton de sécurité invalide');
            return $this->redirectToRoute('app_oeuvre');
        }

        // vérifier si l'utilisateur a déjà effectué lemprunt de cet exemplaire 
        $empruntExistant = $empruntRepository->rechercheParUtilisateurEtOeuvre(
            $this->getUser(),
            $oeuvre
        );

        if ($empruntExistant) {
            $this->addFlash('error', 'Vous avez déjà réservé cette oeuvre.');
            return $this->redirectToRoute('app_oeuvre');
        }

        // trouver un exemplaire disponible
        $exemplaireDisponible = $exemplaireRepository->findOneBy([
            'oeuvre' => $oeuvre,
            'disponibilite' => true
        ]);
       
        // si l'exemplaire n'ets pas disponible
        if (!$exemplaireDisponible) {
            $this->addFlash('error', 'Aucun exemplaire disponible pour cette oeuvre');
            return $this->redirectToRoute('app_oeuvre');
        }

        // créer la réservation (valable 7 jours)
        $maintenant = new DateTimeImmutable();

        $emprunt = new Emprunt();
        $emprunt->setUtilisateur($this->getUser());
        $emprunt->setExemplaire($exemplaireDisponible);
        $emprunt->setDateReservation($maintenant);
        $emprunt->setStatutReservation(StatutReservation::RESERVE);

        // bloquer l'exemplaire
        $exemplaireDisponible->setDisponibilite(false);
        $em->persist($emprunt);
        $em->flush();

        // $this->addFlash('success', 'Réservation confirmée');
        $this->addFlash('success', sprintf(
             'Réservation confirmée (exemplaire %s) ! Valable 7 jours (jusqu\'au %s).',
             $exemplaireDisponible->getCodeInventaire(),
             $maintenant->modify('+7 days')->format('d/m/Y')
        ));

        return $this->redirectToRoute('app_oeuvre');
    }
}
