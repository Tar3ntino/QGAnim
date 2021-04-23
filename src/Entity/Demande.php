<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eventLocation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberPeople;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventType;

    /**
     * @ORM\Column(type="date")
     */
    private $eventDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $animationSchedules;

    /**
     * @ORM\Column(type="integer")
     */
    private $budgetClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $otherComments;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $nameRequester;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $firstNameRequester;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameCompanyOrAssociation;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $emailRequester;

    /**
     * @ORM\Column(type="string", length=35)
     */
    private $phoneRequester;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="demandes")
     */
    private $user;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Devis::class, mappedBy="demande")
     */
    private $devis;

    public function __toString()
    {
        return $this->eventType . "organisé par" . $this->getUser()->__toString;
    }

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventLocation(): ?string
    {
        return $this->eventLocation;
    }

    public function setEventLocation(?string $eventLocation): self
    {
        $this->eventLocation = $eventLocation;

        return $this;
    }

    public function getNumberPeople(): ?int
    {
        return $this->numberPeople;
    }

    public function setNumberPeople(?int $numberPeople): self
    {
        $this->numberPeople = $numberPeople;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getAnimationSchedules(): ?string
    {
        return $this->animationSchedules;
    }

    public function setAnimationSchedules(?string $animationSchedules): self
    {
        $this->animationSchedules = $animationSchedules;

        return $this;
    }

    public function getBudgetClient(): ?int
    {
        return $this->budgetClient;
    }

    public function setBudgetClient(int $budgetClient): self
    {
        $this->budgetClient = $budgetClient;

        return $this;
    }

    public function getOtherComments(): ?string
    {
        return $this->otherComments;
    }

    public function setOtherComments(string $otherComments): self
    {
        $this->otherComments = $otherComments;

        return $this;
    }

    public function getNameRequester(): ?string
    {
        return $this->nameRequester;
    }

    public function setNameRequester(string $nameRequester): self
    {
        $this->nameRequester = $nameRequester;

        return $this;
    }

    public function getFirstNameRequester(): ?string
    {
        return $this->firstNameRequester;
    }

    public function setFirstNameRequester(string $firstNameRequester): self
    {
        $this->firstNameRequester = $firstNameRequester;

        return $this;
    }

    public function getNameCompanyOrAssociation(): ?string
    {
        return $this->nameCompanyOrAssociation;
    }

    public function setNameCompanyOrAssociation(?string $nameCompanyOrAssociation): self
    {
        $this->nameCompanyOrAssociation = $nameCompanyOrAssociation;

        return $this;
    }

    public function getEmailRequester(): ?string
    {
        return $this->emailRequester;
    }

    public function setEmailRequester(string $emailRequester): self
    {
        $this->emailRequester = $emailRequester;

        return $this;
    }

    public function getPhoneRequester(): ?string
    {
        return $this->phoneRequester;
    }

    public function setPhoneRequester(string $phoneRequester): self
    {
        $this->phoneRequester = $phoneRequester;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): self
    {
        if (!$this->devis->contains($devi)) {
            $this->devis[] = $devi;
            $devi->setDemande($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getDemande() === $this) {
                $devi->setDemande(null);
            }
        }

        return $this;
    }

}
