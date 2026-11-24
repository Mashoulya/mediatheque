<?php

namespace App\Controller\Admin;

use App\Entity\Emprunt;
use App\Enum\StatutReservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class EmpruntCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Emprunt::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('dateReservation', 'Date de réservation'),
            DateTimeField::new('dateEmprunt', 'Date d\'emprunt')->setRequired(false),
            DateTimeField::new('dateRetourPrevu', 'Date de retour prévue')->setRequired(false),
            DateTimeField::new('dateRetourReelle', 'Date de retour réelle')->setRequired(false),
            ChoiceField::new('statutReservation', 'Statut de réservation')
                ->setChoices([
                    'Reservé' => StatutReservation::RESERVE,
                    'Disponible pour le retrait' => StatutReservation::DISPONIBLE,
                    'Emprunté' => StatutReservation::EMPRUNTE,
                    'Rendu' => StatutReservation::RENDU,
                    'Annulé' => StatutReservation::ANNULE
                ]),

        ];
    }
}
