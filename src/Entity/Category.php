<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Artwork", inversedBy="categories")
     */
    private $artwork;

    public function __construct()
    {
        $this->artwork = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Artwork[]
     */
    public function getArtwork(): Collection
    {
        return $this->artwork;
    }

    public function addArtwork(Artwork $artwork): self
    {
        if (!$this->artwork->contains($artwork)) {
            $this->artwork[] = $artwork;
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artwork->contains($artwork)) {
            $this->artwork->removeElement($artwork);
        }

        return $this;
    }
}
