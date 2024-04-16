<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClubuserRepository;
#[ORM\Entity(repositoryClass: ClubuserRepository::class)]


class Clubuser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idUser = null;
    

    #[ORM\Column]
    private ?string $idClub = null;
    

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
