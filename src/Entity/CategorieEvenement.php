<?php

namespace App\Entity;

use App\Repository\CategorieEvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieEvenementRepository::class)]
#[ORM\Table(name: "categorie_evenement")]
class CategorieEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Category name should not be blank.')]
    private ?string $nom_cat_e = null;

    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'categorie')]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCatE(): ?string
    {
        return $this->nom_cat_e;
    }

    public function setNomCatE(string $nom_cat_e): static
    {
        $this->nom_cat_e = $nom_cat_e;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setCategorie($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getCategorie() === $this) {
                $evenement->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom_cat_e;
    }
}
