<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clubuser
 *
 * @ORM\Table(name="clubuser", indexes={@ORM\Index(name="FK_club", columns={"id_club"})})
 * @ORM\Entity(repositoryClass=App\Repository\ClubuserRepository::class)
 */
class Clubuser
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="id_club", type="integer", nullable=false)
     */
    private $idClub;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getIdClub(): ?int
    {
        return $this->idClub;
    }

    public function setIdClub(int $idClub): static
    {
        $this->idClub = $idClub;

        return $this;
    }


}
