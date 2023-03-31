<?php

namespace App\Entity;

use App\Repository\DessertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DessertRepository::class)]
class Dessert
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

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'desserts')]
    private Collection $desserts;

    public function __construct()
    {
        $this->desserts = new ArrayCollection();
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
    public function getDesserts(): Collection
    {
        return $this->desserts;
    }

    public function addDessert(Menu $dessert): self
    {
        if (!$this->desserts->contains($dessert)) {
            $this->desserts->add($dessert);
            $dessert->addDessert($this);
        }

        return $this;
    }

    public function removeDessert(Menu $dessert): self
    {
        if ($this->desserts->removeElement($dessert)) {
            $dessert->removeDessert($this);
        }

        return $this;
    }
}
