<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffreRepository;
#[ORM\Entity(repositoryClass: OffreRepository::class)]

class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idOffre = null;
   

    #[ORM\Column(length: 255)]
    private ?string $titre = null;
    

    #[ORM\Column(length: 255)]
    private ?string $description = null;
    

    #[ORM\Column(length: 255)]
    private ?string $reduction = null;
    
    #[ORM\Column(length: 255)]
    private ?string $produit = null;
    

    #[ORM\ManyToOne(inversedBy:'Sponsor')]
    #[ORM\JoinColumn]
    private ?Sponsor $idSponsor = null;
    

    public function getIdOffre(): ?int
    {
        return $this->idOffre;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getReduction(): ?string
    {
        return $this->reduction;
    }

    public function setReduction(string $reduction): static
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getIdSponsor(): ?int
    {
        return $this->idSponsor;
    }

    public function setIdSponsor(int $idSponsor): static
    {
        $this->idSponsor = $idSponsor;

        return $this;
    }


}
