<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="categ", columns={"categorie_evenement_id"})})
 * @ORM\Entity(repositoryClass=App\Repository\EvenementRepository::class)
 */
class Evenement
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
     * @ORM\Column(name="nom_e", type="string", length=255, nullable=false)
     */
    private $nomE;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_participants", type="integer", nullable=false)
     */
    private $nbrParticipants;

    /**
     * @var string
     *
     * @ORM\Column(name="description_e", type="string", length=255, nullable=false)
     */
    private $descriptionE;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_e", type="string", length=255, nullable=false)
     */
    private $lieuE;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="categorie_evenement_id", type="integer", nullable=false)
     */
    private $categorieEvenementId;

    /**
     * @var string
     *
     * @ORM\Column(name="date_e", type="string", length=255, nullable=false)
     */
    private $dateE;

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
