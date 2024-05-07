<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AffiliationRepository;
#[ORM\Entity(repositoryClass: AffiliationRepository::class)]


class Affiliation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    

    #[ORM\Column(length: 255)]
    private ?string $cin= null;
    

    #[ORM\Column]
    private ?int $age= null;
    

    #[ORM\Column(length: 255)]
    private ?string $email = null;
    

    #[ORM\Column(length: 255)]
    private ?string $idclub = null;
    

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getIdclub(): ?int
    {
        return $this->idclub;
    }

    public function setIdclub(int $idclub): static
    {
        $this->idclub = $idclub;

        return $this;
    }


}
