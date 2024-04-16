<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieEvenementRepository;
#[ORM\Entity(repositoryClass: CategorieEvenementRepository::class)]


class CategorieEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCatE = null;
    

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
