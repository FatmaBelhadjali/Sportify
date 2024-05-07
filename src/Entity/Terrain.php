<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TerrainRepository;

#[ORM\Entity(repositoryClass: TerrainRepository::class)]
class Terrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idTerrain = null;
    

    #[ORM\Column(length: 255)]
    private ?string $nomterrain = null;
    

    #[ORM\Column(length: 255)]
    private ?string $localisation = null;
    

    #[ORM\Column]
    private ?string $taille = null;
    

    #[ORM\ManyToOne(inversedBy: 'terrains')]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id")]
    private ?Sport $sport = null; 
    

    public function getIdTerrain(): ?int
    {
        return $this->idTerrain;
    }

    public function getNomterrain(): ?string
    {
        return $this->nomterrain;
    }

    public function setNomterrain(string $nomterrain): static
    {
        $this->nomterrain = $nomterrain;

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

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }


}
