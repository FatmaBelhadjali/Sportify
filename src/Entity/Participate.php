<?php

namespace App\Entity;

use App\Repository\ParticipateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipateRepository::class)]
class Participate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_user_id = null;

    #[ORM\Column]
    private ?int $id_event_id = null;

    #[ORM\Column]
    private ?int $verification_code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUserId(): ?int
    {
        return $this->id_user_id;
    }

    public function setIdUserId(int $id_user_id): static
    {
        $this->id_user_id = $id_user_id;

        return $this;
    }

    public function getIdEventId(): ?int
    {
        return $this->id_event_id;
    }

    public function setIdEventId(int $id_event_id): static
    {
        $this->id_event_id = $id_event_id;

        return $this;
    }

    public function getVerificationCode(): ?int
    {
        return $this->verification_code;
    }

    public function setVerificationCode(int $verification_code): static
    {
        $this->verification_code = $verification_code;

        return $this;
    }
}
