<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieEvenement
 *
 * @ORM\Table(name="categorie_evenement")
 * @ORM\Entity(repositoryClass=App\Repository\CategorieEvenementRepository::class)
 */
class CategorieEvenement
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
     * @ORM\Column(name="nom_cat_e", type="string", length=255, nullable=false)
     */
    private $nomCatE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCatE(): ?string
    {
        return $this->nomCatE;
    }

    public function setNomCatE(string $nomCatE): static
    {
        $this->nomCatE = $nomCatE;

        return $this;
    }


}
