<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PresentationRepository;

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
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageTop;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageBottom;

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
     * Get the value of imageBottom
     */ 
    public function getImageBottom()
    {
        return $this->imageBottom;
    }

    /**
     * Set the value of imageBottom
     *
     * @return  self
     */ 
    public function setImageBottom($imageBottom)
    {
        $this->imageBottom = $imageBottom;

        return $this;
    }

    /**
     * Get the value of imageTop
     */ 
    public function getImageTop()
    {
        return $this->imageTop;
    }

    /**
     * Set the value of imageTop
     *
     * @return  self
     */ 
    public function setImageTop($imageTop)
    {
        $this->imageTop = $imageTop;

        return $this;
    }
}
