<?php

namespace App\Entity;

use App\Repository\SortieCaisseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SortieCaisseRepository::class)]
class SortieCaisse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Sortie_Caisse = null;

    #[ORM\Column]
    private ?float $Montant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $Id_Utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDepense $Id_Type_Depence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSortieCaisse(): ?\DateTimeInterface
    {
        return $this->Date_Sortie_Caisse;
    }

    public function setDateSortieCaisse(\DateTimeInterface $Date_Sortie_Caisse): static
    {
        $this->Date_Sortie_Caisse = $Date_Sortie_Caisse;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getIdUtilisateur(): ?users
    {
        return $this->Id_Utilisateur;
    }

    public function setIdUtilisateur(?users $Id_Utilisateur): static
    {
        $this->Id_Utilisateur = $Id_Utilisateur;

        return $this;
    }

    public function getIdTypeDepence(): ?TypeDepense
    {
        return $this->Id_Type_Depence;
    }

    public function setIdTypeDepence(?TypeDepense $Id_Type_Depence): static
    {
        $this->Id_Type_Depence = $Id_Type_Depence;

        return $this;
    }
}
