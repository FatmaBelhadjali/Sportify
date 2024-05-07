<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SponsorRepository;
#[ORM\Entity(repositoryClass: SponsorRepository::class)]


class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idSponsor = null;
    

    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;
    

    #[ORM\Column]
    private ?int $numero = null;
    

    #[ORM\Column(length: 255)]
    private ?string $logo = null;
    

    #[ORM\Column(length: 255)]
    private ?string $evenement = null;
    

    public function getIdSponsor(): ?int
    {
        return $this->idSponsor;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getEvenement(): ?string
    {
        return $this->evenement;
    }

    public function setEvenement(string $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }


}
