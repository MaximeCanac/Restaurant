<?php

namespace App\Entity;

use App\Repository\EntreeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntreeRepository::class)]
class Entree
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $ingredient = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix = null;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'entrees')]
    private Collection $entrees;

    public function __construct()
    {
        $this->entrees = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIngredient(): ?string
    {
        return $this->ingredient;
    }

    public function setIngredient(string $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getEntrees(): Collection
    {
        return $this->entrees;
    }

    public function addEntree(Menu $entree): self
    {
        if (!$this->entrees->contains($entree)) {
            $this->entrees->add($entree);
            $entree->addEntree($this);
        }

        return $this;
    }

    public function removeEntree(Menu $entree): self
    {
        if ($this->entrees->removeElement($entree)) {
            $entree->removeEntree($this);
        }

        return $this;
    }
}
