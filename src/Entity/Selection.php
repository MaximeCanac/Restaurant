<?php

namespace App\Entity;

use App\Repository\SelectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SelectionRepository::class)]
class Selection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $entrees = null;

    #[ORM\Column(length: 255)]
    private ?string $plats = null;

    #[ORM\Column(length: 255)]
    private ?string $desserts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntrees(): ?string
    {
        return $this->entrees;
    }

    public function setEntrees(string $entrees): self
    {
        $this->entrees = $entrees;

        return $this;
    }

    public function getPlats(): ?string
    {
        return $this->plats;
    }

    public function setPlats(string $plats): self
    {
        $this->plats = $plats;

        return $this;
    }

    public function getDesserts(): ?string
    {
        return $this->desserts;
    }

    public function setDesserts(string $desserts): self
    {
        $this->desserts = $desserts;

        return $this;
    }
}
