<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipement
 *
 * @ORM\Table(name="equipement", indexes={@ORM\Index(name="club", columns={"club_id"})})
 * @ORM\Entity(repositoryClass=App\Repository\EquipementRepository::class)
 */
class Equipement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEquipement", type="string", length=255, nullable=false)
     */
    private $nomequipement;

    /**
     * @var int
     *
     * @ORM\Column(name="qteEquipement", type="integer", nullable=false)
     */
    private $qteequipement;

    /**
     * @var string
     *
     * @ORM\Column(name="imageEquipement", type="string", length=255, nullable=false)
     */
    private $imageequipement;

    /**
     * @var int
     *
     * @ORM\Column(name="club_id", type="integer", nullable=false)
     */
    private $clubId;

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
