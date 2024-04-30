<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Affiliation
 *
 * @ORM\Table(name="affiliation", indexes={@ORM\Index(name="club", columns={"idclub"})})
 * @ORM\Entity(repositoryClass=App\Repository\AffiliationRepository::class)
 */
class Affiliation
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom ne peut pas être vide.")
     * @Assert\Length(max=200, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="CIN ne peut pas être vide.")
     * @Assert\Length(max=8, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
     */
    private $cin;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     * @Assert\NotBlank(message="L'age ne peut pas être vide.")
     * @Assert\Length(max=200, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
     * @Assert\GreaterThanOrEqual(value=18, message="L'âge doit être égal ou supérieur à 18.")

     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * * @Assert\NotBlank(message="L'email ne peut pas être vide.")
     * @Assert\Length(max=200, maxMessage="L'email du club ne peut pas dépasser {{ limit }} caractères.")
     * @Assert\Regex(
 *     pattern="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
 *     message="L'email '{{ value }}' n'a pas une structure valide."
 * )
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="idclub", type="integer", nullable=false)
     * * @Assert\NotBlank(message="Le club ne peut pas être vide.")
     * @Assert\Length(max=200, maxMessage="Le nom du club ne peut pas dépasser {{ limit }} caractères.")
     */
    private $idclub;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getIdclub(): ?int
    {
        return $this->idclub;
    }

    public function setIdclub(int $idclub): static
    {
        $this->idclub = $idclub;

        return $this;
    }


}
