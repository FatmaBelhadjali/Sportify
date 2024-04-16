<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PanierRepository;
#[ORM\Entity(repositoryClass: PanierRepository::class)]


class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
   

    #[ORM\Column(length: 255)]
    private ?int $quantity = null;
    

    #[ORM\Column]
    private ?float $total = null;
    

    #[ORM\ManyToOne(inversedBy:'Produit')]
    #[ORM\JoinColumn]
    private ?Produit $idproduct = null;
    

    #[ORM\ManyToOne(inversedBy:'Utilisateurs')]
    #[ORM\JoinColumn]
    private ?Utilisateurs $iduser = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getIdproduct(): ?int
    {
        return $this->idproduct;
    }

    public function setIdproduct(int $idproduct): static
    {
        $this->idproduct = $idproduct;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }


}
