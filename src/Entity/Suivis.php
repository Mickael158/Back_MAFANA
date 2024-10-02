<?php

namespace App\Entity;

use App\Repository\SuivisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuivisRepository::class)]
class Suivis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $Administrateur_Id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateAttribution = null;

    #[ORM\Column(length: 255)]
    private ?string $Role = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $Utilisateur_Id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdministrateurId(): ?users
    {
        return $this->Administrateur_Id;
    }

    public function setAdministrateurId(?users $Administrateur_Id): static
    {
        $this->Administrateur_Id = $Administrateur_Id;

        return $this;
    }

    public function getDateAttribution(): ?\DateTimeInterface
    {
        return $this->DateAttribution;
    }

    public function setDateAttribution(\DateTimeInterface $DateAttribution): static
    {
        $this->DateAttribution = $DateAttribution;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    public function getUtilisateurId(): ?users
    {
        return $this->Utilisateur_Id;
    }

    public function setUtilisateurId(?users $Utilisateur_Id): static
    {
        $this->Utilisateur_Id = $Utilisateur_Id;

        return $this;
    }
}
