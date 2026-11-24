<?php

namespace App\Enum;

enum StatutReservation: string
{
    case RESERVE = 'reserve';
    case DISPONIBLE = 'disponible';
    case EMPRUNTE = 'emprunte';
    case RENDU = 'rendu';
    case ANNULE = 'annule';

    public function voirStatut (): string 
    {
        return match($this) {
            self::RESERVE => 'Reservé (en attente de retrait)',
            self::DISPONIBLE => 'Disponible pour le retrait',
            self::EMPRUNTE => 'Emprunté',
            self::RENDU => 'Rendu',
            self::ANNULE => 'Annulé',
        };
    }
  }

  