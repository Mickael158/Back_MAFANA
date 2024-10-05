<?php

namespace App\Entity;

use App\Repository\ImportMembreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImportMembreRepository::class)]
class ImportMembre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Anarana = null;

    #[ORM\Column(length: 255)]
    private ?string $Fanampiny = null;

    #[ORM\Column(length: 255)]
    private ?string $Daty_Naterahana = null;

    #[ORM\Column(length: 255)]
    private ?string $Lahy_na_Vavy = null;

    #[ORM\Column(length: 255)]
    private ?string $Adiresy_eto_Antananarivo = null;

    #[ORM\Column(length: 255)]
    private ?string $Trangobe = null;

    #[ORM\Column(length: 255)]
    private ?string $Fiaviana_Antanana = null;

    #[ORM\Column(length: 255)]
    private ?string $LaharanaFinday = null;

    #[ORM\Column(length: 255)]
    private ?string $mailaka = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnarana(): ?string
    {
        return $this->Anarana;
    }

    public function setAnarana(string $Anarana): static
    {
        $this->Anarana = $Anarana;

        return $this;
    }

    public function getFanampiny(): ?string
    {
        return $this->Fanampiny;
    }

    public function setFanampiny(string $Fanampiny): static
    {
        $this->Fanampiny = $Fanampiny;

        return $this;
    }

    public function getDatyNaterahana(): ?string
    {
        return $this->Daty_Naterahana;
    }

    public function setDatyNaterahana(string $Daty_Naterahana): static
    {
        $this->Daty_Naterahana = $Daty_Naterahana;

        return $this;
    }

    public function getLahyNaVavy(): ?string
    {
        return $this->Lahy_na_Vavy;
    }

    public function setLahyNaVavy(string $Lahy_na_Vavy): static
    {
        $this->Lahy_na_Vavy = $Lahy_na_Vavy;

        return $this;
    }

    public function getAdiresyEtoAntananarivo(): ?string
    {
        return $this->Adiresy_eto_Antananarivo;
    }

    public function setAdiresyEtoAntananarivo(string $Adiresy_eto_Antananarivo): static
    {
        $this->Adiresy_eto_Antananarivo = $Adiresy_eto_Antananarivo;

        return $this;
    }

    public function getTrangobe(): ?string
    {
        return $this->Trangobe;
    }

    public function setTrangobe(string $Trangobe): static
    {
        $this->Trangobe = $Trangobe;

        return $this;
    }

    public function getFiavianaAntanana(): ?string
    {
        return $this->Fiaviana_Antanana;
    }

    public function setFiavianaAntanana(string $Fiaviana_Antanana): static
    {
        $this->Fiaviana_Antanana = $Fiaviana_Antanana;

        return $this;
    }

    public function getLaharanaFinday(): ?string
    {
        return $this->LaharanaFinday;
    }

    public function setLaharanaFinday(string $LaharanaFinday): static
    {
        $this->LaharanaFinday = $LaharanaFinday;

        return $this;
    }

    public function getMailaka(): ?string
    {
        return $this->mailaka;
    }

    public function setMailaka(string $mailaka): static
    {
        $this->mailaka = $mailaka;

        return $this;
    }
}
