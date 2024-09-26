<?php

namespace App\Entity;

use App\Repository\DonnationMaterielRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: DonnationMaterielRepository::class)]
class DonnationMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $Nom_Donnateur_Materiel = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Acquisition = null;

    #[ORM\Column]
    private ?int $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materiel $Id_Materiel = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $id_utilisateur_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDonnateurMateriel(): ?string
    {
        return $this->Nom_Donnateur_Materiel;
    }

    public function setNomDonnateurMateriel(?string $Nom_Donnateur_Materiel): static
    {
        $this->Nom_Donnateur_Materiel = $Nom_Donnateur_Materiel;

        return $this;
    }


    public function getDateAcquisition(): ?\DateTimeInterface
    {
        return $this->Date_Acquisition;
    }

    public function setDateAcquisition(\DateTimeInterface $Date_Acquisition): static
    {
        $this->Date_Acquisition = $Date_Acquisition;

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->Nombre;
    }

    public function setNombre(int $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function getIdMateriel(): ?Materiel
    {
        return $this->Id_Materiel;
    }

    public function setIdMateriel(?Materiel $Id_Materiel): static
    {
        $this->Id_Materiel = $Id_Materiel;

        return $this;
    }

    public function getIdUtilisateurId(): ?users
    {
        return $this->id_utilisateur_id;
    }

    public function setIdUtilisateurId(?users $id_utilisateur_id): static
    {
        $this->id_utilisateur_id = $id_utilisateur_id;

        return $this;
    }

}
