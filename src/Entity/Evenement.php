<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ORM\Table(name: "evenement")]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255,name: "nom_e")]
    #[Assert\NotBlank(message: 'name should not be blank.')]
    private ?string $nom_e = null;

    #[ORM\Column(name: "nbr_participants")]
    #[Assert\NotBlank(message: 'nbr_participants must not be blank.')]
    #[Assert\Positive(message: 'nbr_participants must be positive.')]
    #[Assert\Range(
        min: 1,
        max: 1000,
        notInRangeMessage: 'nbr_participants must be between {{ min }} and {{ max }}.'
    )]
    private ?int $nbr_participants = null;

    #[ORM\Column(length: 255,name: "description_e")]
    #[Assert\NotBlank(message: 'description should not be blank.')]
    private ?string $description_e = null;

    #[ORM\Column(length: 255,name: "image")]
    #[Assert\NotBlank(message: 'Image should not be blank.')]
    private ?string $image = null;

    #[ORM\Column(length: 255,name: "lieu_e")]
    #[Assert\NotBlank(message: 'Lieu should not be blank.')]
    private ?string $lieu = null;

    #[ORM\Column(length: 255,name: "Etat")]
    #[Assert\NotBlank(message: 'Etat should not be blank.')]
    private ?string $Etat = null;

    #[ORM\Column(length: 255,name: "date_e")]
    #[Assert\NotBlank(message: 'date should not be blank.')]
    private ?string $date_e = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false,name: 'categorie_evenement_id', referencedColumnName: 'id')]
    private ?CategorieEvenement $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomE(): ?string
    {
        return $this->nom_e;
    }

    public function setNomE(string $nom_e): static
    {
        $this->nom_e = $nom_e;

        return $this;
    }

    public function getNbrParticipants(): ?int
    {
        return $this->nbr_participants;
    }

    public function setNbrParticipants(int $nbr_participants): static
    {
        $this->nbr_participants = $nbr_participants;

        return $this;
    }

    public function getDescriptionE(): ?string
    {
        return $this->description_e;
    }

    public function setDescriptionE(string $description_e): static
    {
        $this->description_e = $description_e;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(string $Etat): static
    {
        $this->Etat = $Etat;

        return $this;
    }

    public function getDateE(): ?string
    {
        return $this->date_e;
    }

    public function setDateE(string $date_e): static
    {
        $this->date_e = $date_e;

        return $this;
    }

    public function getCategorie(): ?CategorieEvenement
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieEvenement $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
