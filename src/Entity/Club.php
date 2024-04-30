<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;




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

    /*#[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: "Le nom ne peut contenir que des lettres de l'alphabet"
    )]*/

   /**
 * @var string
 *
 * @ORM\Column(name="nomClub", type="string", length=200, nullable=false)
 * @Assert\NotBlank(message="Le nom du club ne peut pas être vide.")
 * @Assert\Length(max=200, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
 */
private $nomclub;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=200, nullable=false)
     * * @Assert\NotBlank(message="La categorie du club ne peut pas être vide.")
     * @Assert\Length(max=200, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="dateCreation", type="string", length=200, nullable=false)
     * * @Assert\NotBlank(message="La date de création du club ne peut pas être vide.")
    * @Assert\Length(max=200, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCoach", type="string", length=200, nullable=false)
     * * @Assert\NotBlank(message="Le nom du club ne peut pas être vide.")
     * @Assert\Length(max=10, maxMessage="Le nom du club ne peut pas dépasser 10 caractères.")
     */
    private $nomcoach;

    /**
     * @var int
     *
     * @ORM\Column(name="nbMembres", type="integer", nullable=false)
     * * @Assert\NotBlank(message="Le nom du coach club ne peut pas être vide.")
    * @Assert\Length(max=10, maxMessage="Le nom du club ne peut pas dépasser {{ 10 }} caractères.")
     */
    private $nbmembres;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     ** @Assert\NotBlank(message="La localisation du club est obligatoire.")
    * @Assert\Length(max=200, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionClub", type="string", length=255, nullable=false)
     * * @Assert\NotBlank(message="La description du club ne peut pas être vide.")
    * @Assert\Length(max=200, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
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
