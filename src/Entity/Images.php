<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $name;

    /**
     * @ORM\ManyToOne(targetEntity=Animations::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $animations;

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

    public function getAnimations(): ?Animations
    {
        return $this->animations;
    }

    public function setAnimations(?Animations $animations): self
    {
        $this->animations = $animations;

        return $this;
    }
}
