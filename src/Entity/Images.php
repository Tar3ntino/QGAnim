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
     * @ORM\JoinColumn(nullable=true)
     */
    protected $animations;

    /**
     * @ORM\ManyToOne(targetEntity=Presentation::class, inversedBy="images")
     */
    private $presentation;

    /**
     * @ORM\ManyToOne(targetEntity=Devis::class, inversedBy="logo")
     */
    private $devis;

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

    public function getPresentation(): ?Presentation
    {
        return $this->presentation;
    }

    public function setPresentation(?Presentation $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): self
    {
        $this->devis = $devis;

        return $this;
    }
    
}
