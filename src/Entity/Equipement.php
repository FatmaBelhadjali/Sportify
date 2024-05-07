<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EquipementRepository;
#[ORM\Entity(repositoryClass: EquipementRepository::class)]


class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
   

    #[ORM\Column(length: 255)]
    private ?string $nomequipement = null;
    

    #[ORM\Column]
    private ?int $qteequipement = null;
    

    #[ORM\Column(length: 255)]
    private ?string $imageequipement = null;
    
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "club_id", referencedColumnName: "id")]
    private ?Club $club = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomequipement(): ?string
    {
        return $this->nomequipement;
    }

    public function setNomequipement(string $nomequipement): static
    {
        $this->nomequipement = $nomequipement;

        return $this;
    }

    public function getQteequipement(): ?int
    {
        return $this->qteequipement;
    }

    public function setQteequipement(int $qteequipement): static
    {
        $this->qteequipement = $qteequipement;

        return $this;
    }

    public function getImageequipement(): ?string
    {
        return $this->imageequipement;
    }

    public function setImageequipement(string $imageequipement): static
    {
        $this->imageequipement = $imageequipement;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(Club $club): self
    {
        $this->club = $club;

        return $this;
    }


}
