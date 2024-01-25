<?php

namespace App\Entity;

use App\Repository\GalerieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalerieRepository::class)]
class Galerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $utilisateur = null;

    #[ORM\Column]
    private ?int $photo = null;

    #[ORM\Column]
    private ?int $ordre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?int
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(int $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getPhoto(): ?int
    {
        return $this->photo;
    }

    public function setPhoto(int $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): static
    {
        $this->ordre = $ordre;

        return $this;
    }
}
