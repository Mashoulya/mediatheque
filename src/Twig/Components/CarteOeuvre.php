<?php

namespace App\Twig\Components;

use App\Entity\Oeuvre;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class CarteOeuvre
{
    public Oeuvre $oeuvre;
}
