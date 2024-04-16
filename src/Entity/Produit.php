<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
#[ORM\Entity(repositoryClass: ProduitRepository::class)]


class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    

    #[ORM\Column(length: 255)]
    private ?string $description = null;
    

    #[ORM\Column(length: 255)]
    private ?string $image = null;
    

    #[ORM\Column]
    private ?float $prix = null;
    

    #[ORM\ManyToOne(inversedBy:'CategorieProduit')]
    #[ORM\JoinColumn]
    private ?CategorieProduit $categorieId = null;
    

    #[ORM\Column]
    private ?int $rating = null;
    

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategorieId(): ?int
    {
        return $this->categorieId;
    }

    public function setCategorieId(int $categorieId): static
    {
        $this->categorieId = $categorieId;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }


}
