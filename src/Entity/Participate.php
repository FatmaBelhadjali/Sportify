<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participate
 *
 * @ORM\Table(name="participate", indexes={@ORM\Index(name="IDX_D02B13879F37AE5", columns={"id_user_id"}), @ORM\Index(name="IDX_D02B138212C041E", columns={"id_event_id"})})
 * @ORM\Entity(repositoryClass=App\Repository\ParticipateRepository::class)
 */
class Participate
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
     * @var int|null
     *
     * @ORM\Column(name="id_user_id", type="integer", nullable=true)
     */
    private $idUserId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_event_id", type="integer", nullable=true)
     */
    private $idEventId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="verification_code", type="integer", nullable=true)
     */
    private $verificationCode;

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
