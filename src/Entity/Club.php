<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass=App\Repository\ClubRepository::class)
 */
class Club
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
     * @ORM\Column(name="nomClub", type="string", length=200, nullable=false)
     */
    private $nomclub;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=200, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="dateCreation", type="string", length=200, nullable=false)
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCoach", type="string", length=200, nullable=false)
     */
    private $nomcoach;

    /**
     * @var int
     *
     * @ORM\Column(name="nbMembres", type="integer", nullable=false)
     */
    private $nbmembres;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionClub", type="string", length=255, nullable=false)
     */
    private $descriptionclub;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=200, nullable=false)
     */
    private $logo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomclub(): ?string
    {
        return $this->nomclub;
    }

    public function setNomclub(string $nomclub): static
    {
        $this->nomclub = $nomclub;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDatecreation(): ?string
    {
        return $this->datecreation;
    }

    public function setDatecreation(string $datecreation): static
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getNomcoach(): ?string
    {
        return $this->nomcoach;
    }

    public function setNomcoach(string $nomcoach): static
    {
        $this->nomcoach = $nomcoach;

        return $this;
    }

    public function getNbmembres(): ?int
    {
        return $this->nbmembres;
    }

    public function setNbmembres(int $nbmembres): static
    {
        $this->nbmembres = $nbmembres;

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

    public function getDescriptionclub(): ?string
    {
        return $this->descriptionclub;
    }

    public function setDescriptionclub(string $descriptionclub): static
    {
        $this->descriptionclub = $descriptionclub;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }


}
