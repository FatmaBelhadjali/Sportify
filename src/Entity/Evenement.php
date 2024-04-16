<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EvenementRepository;
#[ORM\Entity(repositoryClass: EvenementRepository::class)]


class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[ORM\Column(length: 255)]
    private ?string $nomE = null;
    

    #[ORM\Column]
    private ?int $nbrParticipants = null;
    

    #[ORM\Column(length: 255)]
    private ?string $descriptionE = null;
    

    #[ORM\Column(length: 255)]
    private ?string $image = null;
    

    #[ORM\Column(length: 255)]
    private ?string $lieuE = null;
    

    #[ORM\Column(length: 255)]
    private ?string $etat = null;
    

    #[ORM\ManyToOne(inversedBy:'CategorieEvenement')]
    #[ORM\JoinColumn]
    private ?Club $categorieEvenementId = null;
    

    #[ORM\Column(length: 255)]
    private ?string $dateE = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomE(): ?string
    {
        return $this->nomE;
    }

    public function setNomE(string $nomE): static
    {
        $this->nomE = $nomE;

        return $this;
    }

    public function getNbrParticipants(): ?int
    {
        return $this->nbrParticipants;
    }

    public function setNbrParticipants(int $nbrParticipants): static
    {
        $this->nbrParticipants = $nbrParticipants;

        return $this;
    }

    public function getDescriptionE(): ?string
    {
        return $this->descriptionE;
    }

    public function setDescriptionE(string $descriptionE): static
    {
        $this->descriptionE = $descriptionE;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getLieuE(): ?string
    {
        return $this->lieuE;
    }

    public function setLieuE(string $lieuE): static
    {
        $this->lieuE = $lieuE;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCategorieEvenementId(): ?int
    {
        return $this->categorieEvenementId;
    }

    public function setCategorieEvenementId(int $categorieEvenementId): static
    {
        $this->categorieEvenementId = $categorieEvenementId;

        return $this;
    }

    public function getDateE(): ?string
    {
        return $this->dateE;
    }

    public function setDateE(string $dateE): static
    {
        $this->dateE = $dateE;

        return $this;
    }


}
