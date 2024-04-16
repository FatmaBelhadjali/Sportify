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
    
    #[ORM\ManyToOne(inversedBy:'Club')]
    #[ORM\JoinColumn]
    private ?Club $clubId = null;
    

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

    public function getClubId(): ?int
    {
        return $this->clubId;
    }

    public function setClubId(int $clubId): static
    {
        $this->clubId = $clubId;

        return $this;
    }


}
