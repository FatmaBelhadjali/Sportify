<?php

namespace App\Entity;



use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit; // Import the Product entity class

#[ORM\Entity(repositoryClass:CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $size;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $quantity;
    

    #[ORM\Column(name:"priceTotal")]
    #[Assert\Positive]
    private ?float $priceTotal;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'carts')]
    #[ORM\JoinColumn(name:"idUser", referencedColumnName: "id")]
    private ?Utilisateurs $idUser;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'carts')]
    #[ORM\JoinColumn(name: "idProduct", referencedColumnName: "id")]
    private ?Produit $idProduct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceTotal(): ?float
    {
        return $this->priceTotal;
    }

    public function setPriceTotal(float $priceTotal): self
    {
        $this->priceTotal = $priceTotal;
        return $this;
    }

    public function getIdUser(): ?Utilisateurs
    {
        return $this->idUser;
    }

    public function setIdUser(?Utilisateurs $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getIdProduct(): ?Produit
    {
        return $this->idProduct;
    }

    public function setIdProduct(?Produit $idProduct): self
    {
        $this->idProduct = $idProduct;
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }


}
