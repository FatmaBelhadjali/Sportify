<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParticipateRepository;
#[ORM\Entity(repositoryClass: ParticipateRepository::class)]

class Participate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[ORM\ManyToOne(inversedBy:'Utilisateurs')]
    #[ORM\JoinColumn]
    private ?Utilisateurs $idUserId = null;
    

    #[ORM\ManyToOne(inversedBy:'Evenement')]
    #[ORM\JoinColumn]
    private ?Evenement $idEventId = null;
    

    #[ORM\Column]
    private ?int $verificationCode = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUserId(): ?int
    {
        return $this->idUserId;
    }

    public function setIdUserId(?int $idUserId): static
    {
        $this->idUserId = $idUserId;

        return $this;
    }

    public function getIdEventId(): ?int
    {
        return $this->idEventId;
    }

    public function setIdEventId(?int $idEventId): static
    {
        $this->idEventId = $idEventId;

        return $this;
    }

    public function getVerificationCode(): ?int
    {
        return $this->verificationCode;
    }

    public function setVerificationCode(?int $verificationCode): static
    {
        $this->verificationCode = $verificationCode;

        return $this;
    }


}
