<?php

namespace App\Entity;

use App\Repository\PresentationRepository;
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
}
