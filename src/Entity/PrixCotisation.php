<?php

namespace App\Entity;

use App\Repository\PrixCotisationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrixCotisationRepository::class)]
class PrixCotisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $Valeur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Modif = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $Id_utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?float
    {
        return $this->Valeur;
    }

    public function setValeur(float $Valeur): static
    {
        $this->Valeur = $Valeur;

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->Date_Modif;
    }

    public function setDateModif(\DateTimeInterface $Date_Modif): static
    {
        $this->Date_Modif = $Date_Modif;

        return $this;
    }

    public function getIdUtilisateur(): ?users
    {
        return $this->Id_utilisateur;
    }

    public function setIdUtilisateur(?users $Id_utilisateur): static
    {
        $this->Id_utilisateur = $Id_utilisateur;

        return $this;
    }
}
