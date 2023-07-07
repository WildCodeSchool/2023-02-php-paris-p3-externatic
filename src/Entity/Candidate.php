<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:100)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:255)]
    private ?string $location = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(min: 2, max:100)]
    private ?string $phone = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\Length(min: 2, max:150)]
    private ?string $resume = null;

    #[ORM\Column(type: Types::TEXT, length: 300, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max:300)]
    private ?string $introduction = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max:150)]
    private ?string $jobTitle = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:100)]
    private ?string $experience = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\Length(min: 2, max:100)]
    private ?string $picture = null;

    #[ORM\OneToOne(inversedBy: 'candidate', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'candidates')]
    private Collection $skills;

    #[ORM\Column(nullable: true)]
    private ?bool $visible = null;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: Application::class)]
    private Collection $applications;

    #[ORM\ManyToMany(targetEntity: Offer::class, mappedBy: 'favorite')]
    private Collection $favoriteOffers;

    #[ORM\ManyToOne(inversedBy: 'favoriteCandidates')]
    private ?Company $favorite = null;

    #[ORM\OneToMany(mappedBy: 'favorite', targetEntity: Company::class)]
    private Collection $favoriteCompanies;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: CandidateMetadata::class, cascade:['persist'])]
    protected Collection $metadata;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->favoriteOffers = new ArrayCollection();
        $this->favoriteCompanies = new ArrayCollection();
        $this->metadata = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getResume(): ?string
    {
        return 'upload/resumees/' . $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getPicture(): ?string
    {
        return 'uploads/candidatePictures/' . $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
            $skill->addCandidate($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeCandidate($this);
        }

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setCandidate($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getCandidate() === $this) {
                $application->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getFavoriteOffers(): Collection
    {
        return $this->favoriteOffers;
    }

    public function addFavoriteOffer(Offer $favoriteOffer): self
    {
        if (!$this->favoriteOffers->contains($favoriteOffer)) {
            $this->favoriteOffers->add($favoriteOffer);
            $favoriteOffer->addFavorite($this);
        }

        return $this;
    }

    public function removeFavoriteOffer(Offer $favoriteOffer): self
    {
        if ($this->favoriteOffers->removeElement($favoriteOffer)) {
            $favoriteOffer->removeFavorite($this);
        }

        return $this;
    }

    public function getFavorite(): ?Company
    {
        return $this->favorite;
    }

    public function setFavorite(?Company $favorite): self
    {
        $this->favorite = $favorite;

        return $this;
    }

    public function getFavoriteCompanies(): Collection
    {
        return $this->favoriteCompanies;
    }

    public function addFavoriteCompany(Company $favoriteCompany): self
    {
        if (!$this->favoriteCompanies->contains($favoriteCompany)) {
            $this->favoriteCompanies->add($favoriteCompany);
            $favoriteCompany->setFavorite($this);
        }

        return $this;
    }

    public function setMetadata(collection $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getMetadata(): Collection
    {
        return $this->metadata;
    }

    public function addMetadata(CandidateMetadata $metadata): self
    {
        if (!$this->metadata->contains($metadata)) {
            $this->metadata->add($metadata);
            $metadata->setCandidate($this);
        }

        return $this;
    }

    // public function removeMetadata(CandidateMetadata $metadata): void
    // {
    //     $this->metadata->removeElement($metadata);
    // }
}
