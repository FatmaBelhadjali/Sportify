<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClubRepository;
#[ORM\Entity(repositoryClass: ClubRepository::class)]


class Club
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $nomclub = null;
    

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;
    

    #[ORM\Column(length: 255)]
    private ?string $datecreation = null;
    

    #[ORM\Column(length: 255)]
    private ?string $nomcoach = null;
    

    #[ORM\Column]
    private ?int $nbmembres = null;
    

    #[ORM\Column(length: 255)]
    private ?string $localisation = null;
    

    #[ORM\Column(length: 255)]
    private ?string $descriptionclub = null;
    

    #[ORM\Column(length: 255)]
    private ?string $logo = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomclub(): ?string
    {
        return $this->nomclub;
    }

    public function setNomclub(string $nomclub): static
    {
        $this->nomclub = $nomclub;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDatecreation(): ?string
    {
        return $this->datecreation;
    }

    public function setDatecreation(string $datecreation): static
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getNomcoach(): ?string
    {
        return $this->nomcoach;
    }

    public function setNomcoach(string $nomcoach): static
    {
        $this->nomcoach = $nomcoach;

        return $this;
    }

    public function getNbmembres(): ?int
    {
        return $this->nbmembres;
    }

    public function setNbmembres(int $nbmembres): static
    {
        $this->nbmembres = $nbmembres;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getDescriptionclub(): ?string
    {
        return $this->descriptionclub;
    }

    public function setDescriptionclub(string $descriptionclub): static
    {
        $this->descriptionclub = $descriptionclub;

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


}
