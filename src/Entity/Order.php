<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
#[ORM\Entity(repositoryClass: OrderRepository::class)]


class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[ORM\Column(length: 255)]
    private ?string $reference = null;
    

    #[ORM\Column(length: 255)]
    private ?string $date = null;
    

    #[ORM\Column]
    private ?float $pricetotal = null;
    

    #[ORM\ManyToOne(inversedBy:'Utilisateurs')]
    #[ORM\JoinColumn]
    private ?Utilisateurs $iduser = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPricetotal(): ?float
    {
        return $this->pricetotal;
    }

    public function setPricetotal(float $pricetotal): static
    {
        $this->pricetotal = $pricetotal;

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
