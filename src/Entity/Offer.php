<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $user = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $addDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $planedAt = null;

    #[ORM\Column(length: 150)]
    private ?string $contract = null;

    #[ORM\Column(length: 100)]
    private ?string $workFromHome = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 150)]
    private ?string $experience = null;

    #[ORM\Column(nullable: true)]
    private ?int $salary = null;

    #[ORM\OneToOne(mappedBy: 'offer', cascade: ['persist', 'remove'])]
    private ?Application $application = null;

    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'offers')]
    private Collection $skills;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Company
    {
        return $this->user;
    }

    public function setUser(?Company $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAddDate(): ?\DateTimeInterface
    {
        return $this->addDate;
    }

    public function setAddDate(\DateTimeInterface $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }

    public function getPlanedAt(): ?\DateTimeInterface
    {
        return $this->planedAt;
    }

    public function setPlanedAt(\DateTimeInterface $planedAt): self
    {
        $this->planedAt = $planedAt;

        return $this;
    }

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    public function getWorkFromHome(): ?string
    {
        return $this->workFromHome;
    }

    public function setWorkFromHome(string $workFromHome): self
    {
        $this->workFromHome = $workFromHome;

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

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(?int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): self
    {
        // set the owning side of the relation if necessary
        if ($application->getOffer() !== $this) {
            $application->setOffer($this);
        }

        $this->application = $application;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->addOffer($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeOffer($this);
        }

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
