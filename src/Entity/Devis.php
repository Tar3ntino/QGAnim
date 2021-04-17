<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 */
class Devis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="devis")
     */
    private $logo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="date")
     */
    private $date_Of_Issue;

    /**
     * @ORM\Column(type="date")
     */
    private $expiration_Date;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $unit_Price;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $tax;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Demande::class, inversedBy="devis", cascade={"persist"})
     */
    private $demande;

    public function __construct()
    {
        $this->logo = new ArrayCollection();
        $this->date_Of_Issue = new \DateTime('NOW');
        // Cette ligne nous permet de mettre la date actuelle au champ date_Of_Issue lors de la génération de l'entité
    } 

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Images[]
     */
    public function getLogo(): Collection
    {
        return $this->logo;
    }

    public function addLogo(Images $logo): self
    {
        if (!$this->logo->contains($logo)) {
            $this->logo[] = $logo;
            $logo->setDevis($this);
        }

        return $this;
    }

    public function removeLogo(Images $logo): self
    {
        if ($this->logo->removeElement($logo)) {
            // set the owning side to null (unless already changed)
            if ($logo->getDevis() === $this) {
                $logo->setDevis(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDateOfIssue(): ?\DateTimeInterface
    {
        return $this->date_Of_Issue;
    }

    public function setDateOfIssue(\DateTimeInterface $date_Of_Issue): self
    {
        $this->date_Of_Issue = $date_Of_Issue;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_Date;
    }

    public function setExpirationDate(\DateTimeInterface $expiration_Date): self
    {
        $this->expiration_Date = $expiration_Date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unit_Price;
    }

    public function setUnitPrice(int $unit_Price): self
    {
        $this->unit_Price = $unit_Price;

        return $this;
    }

    public function getTax(): ?string
    {
        return $this->tax;
    }

    public function setTax(?string $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }
}
