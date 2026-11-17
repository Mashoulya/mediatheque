<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateEmprunt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateRetourPrevu = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateRetourReelle = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Exemplaire $exemplaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?\DateTimeImmutable
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeImmutable $dateEmprunt): static
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    public function getDateRetourPrevu(): ?\DateTimeImmutable
    {
        return $this->dateRetourPrevu;
    }

    public function setDateRetourPrevu(\DateTimeImmutable $dateRetourPrevu): static
    {
        $this->dateRetourPrevu = $dateRetourPrevu;

        return $this;
    }

    public function getDateRetourReelle(): ?\DateTimeImmutable
    {
        return $this->dateRetourReelle;
    }

    public function setDateRetourReelle(?\DateTimeImmutable $dateRetourReelle): static
    {
        $this->dateRetourReelle = $dateRetourReelle;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getExemplaire(): ?Exemplaire
    {
        return $this->exemplaire;
    }

    public function setExemplaire(?Exemplaire $exemplaire): static
    {
        $this->exemplaire = $exemplaire;

        return $this;
    }
}
