<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Entree::class, inversedBy: 'entrees')]
    private Collection $entrees;

    #[ORM\ManyToMany(targetEntity: Plat::class, inversedBy: 'plats')]
    private Collection $plats;

    #[ORM\ManyToMany(targetEntity: Dessert::class, inversedBy: 'desserts')]
    private Collection $desserts;

    public function __construct()
    {
        $this->entrees = new ArrayCollection();
        $this->plats = new ArrayCollection();
        $this->desserts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, entree>
     */
    public function getEntrees(): Collection
    {
        return $this->entrees;
    }

    public function addEntree(entree $entree): self
    {
        if (!$this->entrees->contains($entree)) {
            $this->entrees->add($entree);
        }

        return $this;
    }

    public function removeEntree(entree $entree): self
    {
        $this->entrees->removeElement($entree);

        return $this;
    }

    /**
     * @return Collection<int, plat>
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(plat $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats->add($plat);
        }

        return $this;
    }

    public function removePlat(plat $plat): self
    {
        $this->plats->removeElement($plat);

        return $this;
    }

    /**
     * @return Collection<int, dessert>
     */
    public function getDesserts(): Collection
    {
        return $this->desserts;
    }

    public function addDessert(dessert $dessert): self
    {
        if (!$this->desserts->contains($dessert)) {
            $this->desserts->add($dessert);
        }

        return $this;
    }

    public function removeDessert(dessert $dessert): self
    {
        $this->desserts->removeElement($dessert);

        return $this;
    }
}
