<?php
namespace App\Service;

use App\Entity\Emprunt;
use App\Entity\Oeuvre;
use App\Entity\Utilisateur;
use App\Enum\StatutReservation;
use App\Repository\EmpruntRepository;
use App\Repository\ExemplaireRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class EmpruntService
{
    public function __construct(
        private EmpruntRepository $empruntRepository,
        private EntityManagerInterface $em,
        private ExemplaireRepository $exemplaireRepository
    ) {

    }
    public function reserverOeuvre(Utilisateur $utilisateur, Oeuvre $oeuvre): Emprunt
    {
         // vérifier si l'utilisateur a déjà effectué lemprunt de cet exemplaire 
        $empruntExistant = $this->empruntRepository->rechercheParUtilisateurEtOeuvre(
            $utilisateur,
            $oeuvre
        );

        if ($empruntExistant) {
            throw new \RuntimeException('Vous avez déjà réservé cette oeuvre.');
        }

         // trouver un exemplaire disponible
        $exemplaireDisponible = $this->exemplaireRepository->findOneBy([
            'oeuvre' => $oeuvre,
            'disponibilite' => true
        ]);
       
        // si l'exemplaire n'ets pas disponible 
        // if (!$exemplaireDisponible) {
        //     $this->addFlash('error', 'Aucun exemplaire disponible pour cette oeuvre');
        //     return $this->redirectToRoute('app_oeuvre');
        // }

        if (!$exemplaireDisponible) {
            throw new \RuntimeException('Aucun exemplaire disponible.');
        }

         // créer la réservation (valable 7 jours)
        $maintenant = new DateTimeImmutable();

        $emprunt = new Emprunt();
        $emprunt->setUtilisateur($utilisateur);
        $emprunt->setExemplaire($exemplaireDisponible);
        $emprunt->setDateReservation($maintenant);
        $emprunt->setStatutReservation(StatutReservation::RESERVE);

        // bloquer l'exemplaire
        $exemplaireDisponible->setDisponibilite(false);
       $this->em->persist($emprunt);
       $this->em->flush();

        return  $emprunt;
    }
}