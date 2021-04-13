<?php

namespace App\Entity;

use App\Repository\PresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PresentationRepository::class)
 */
class Presentation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $topDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bottomDescription;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="presentation", cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopDescription(): ?string
    {
        return $this->topDescription;
    }

    public function setTopDescription(?string $topDescription): self
    {
        $this->topDescription = $topDescription;

        return $this;
    }

    public function getBottomDescription(): ?string
    {
        return $this->bottomDescription;
    }

    public function setBottomDescription(?string $bottomDescription): self
    {
        $this->bottomDescription = $bottomDescription;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPresentation($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPresentation() === $this) {
                $image->setPresentation(null);
            }
        }

        return $this;
    }
}
