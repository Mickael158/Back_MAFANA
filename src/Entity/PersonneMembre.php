<?php

namespace App\Entity;

use App\Repository\PersonneMembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonneMembreRepository::class)]
class PersonneMembre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['personne_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    #[Groups(['personne_read'])]
    private ?string $Nom_Membre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['personne_read'])]
    private ?\DateTimeInterface $Date_de_Naissance = null;

    #[ORM\Column(length: 500)]
    #[Groups(['personne_read'])]
    private ?string $Address = null;

    #[ORM\Column(length: 5000)]
    #[Groups(['personne_read'])]
    private ?string $Email = null;

    #[ORM\Column(length: 500)]
    #[Groups(['personne_read'])]
    private ?string $Prenom_Membre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['personne_read'])]
    private ?Village $Id_Village = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['personne_read'])]
    private ?Genre $Id_Genre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['personne_read'])]
    private ?\DateTimeInterface $Date_Inscription = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['personne_read'])]
    private ?string $Fokotany = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['personne_read'])]
    private ?string $AddressTana = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['personne_read'])]
    private ?string $CIN = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['personne_read'])]
    private ?string $Arrondissement = null;

    #[ORM\OneToMany(mappedBy: 'Id_Personne_Membre', targetEntity: Telephone::class, orphanRemoval: true)]
    #[Groups(['personne_read'])]
    private Collection $telephones;


    public function __construct()
    {
        $this->telephones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMembre(): ?string
    {
        return $this->Nom_Membre;
    }

    public function setNomMembre(string $Nom_Membre): static
    {
        $this->Nom_Membre = $Nom_Membre;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->Date_de_Naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $Date_de_Naissance): static
    {
        $this->Date_de_Naissance = $Date_de_Naissance;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPrenomMembre(): ?string
    {
        return $this->Prenom_Membre;
    }

    public function setPrenomMembre(string $Prenom_Membre): static
    {
        $this->Prenom_Membre = $Prenom_Membre;

        return $this;
    }

    public function getIdVillage(): ?Village
    {
        return $this->Id_Village;
    }

    public function setIdVillage(?Village $Id_Village): static
    {
        $this->Id_Village = $Id_Village;

        return $this;
    }

    public function getIdGenre(): ?genre
    {
        return $this->Id_Genre;
    }

    public function setIdGenre(?genre $Id_Genre): static
    {
        $this->Id_Genre = $Id_Genre;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->Date_Inscription;
    }

    public function setDateInscription(\DateTimeInterface $Date_Inscription): static
    {
        $this->Date_Inscription = $Date_Inscription;

        return $this;
    }

    public function getFokotany(): ?string
    {
        return $this->Fokotany;
    }

    public function setFokotany(?string $Fokotany): static
    {
        $this->Fokotany = $Fokotany;

        return $this;
    }

    public function getAddressTana(): ?string
    {
        return $this->AddressTana;
    }

    public function setAddressTana(?string $AddressTana): static
    {
        $this->AddressTana = $AddressTana;

        return $this;
    }

    public function getCIN(): ?string
    {
        return $this->CIN;
    }

    public function setCIN(?string $CIN): static
    {
        $this->CIN = $CIN;

        return $this;
    }

    public function getArrondissement(): ?string
    {
        return $this->Arrondissement;
    }

    public function setArrondissement(string $Arrondissement): static
    {
        $this->Arrondissement = $Arrondissement;

        return $this;
    }
    public function getTelephones(): Collection
{
    return $this->telephones;
}

public function addTelephones(Telephone $telephone): static
{
    if (!$this->telephones->contains($telephone)) {
        $this->telephones->add($telephone);
        $telephone->setIdPersonneMembre($this);
    }
    return $this;
}

public function removeTelephones(Telephone $telephone): static
{
    if ($this->telephones->removeElement($telephone)) {
        // Set the owning side to null (unless already changed)
        if ($telephone->getIdPersonneMembre() === $this) {
            $telephone->setIdPersonneMembre(null);
        }
    }
    return $this;
}

}
