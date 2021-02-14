<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Animations::class, mappedBy="categories")
     */
    private $animations;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->animations = new ArrayCollection();
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
     * @return Collection|Animations[]
     */
    public function getAnimations(): Collection
    {
        return $this->animations;
    }

    public function addAnimation(Animations $animation): self
    {
        if (!$this->animations->contains($animation)) {
            $this->animations[] = $animation;
            $animation->addCategory($this);
        }

        return $this;
    }

    public function removeAnimation(Animations $animation): self
    {
        if ($this->animations->removeElement($animation)) {
            $animation->removeCategory($this);
        }

        return $this;
    }
}
