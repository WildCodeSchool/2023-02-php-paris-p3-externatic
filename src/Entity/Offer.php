<?php

namespace App\Entity;

use ArrayAccess;
use App\Entity\Skill;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use DateTimeImmutable;
use DateTime;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
#[Vich\Uploadable]
class Offer
{
    public const JOB_TYPE = [
        'Permanent contract' => 'permanent-contract',
        'Work study' => 'work-study',
        'Internship' => 'internship',
        'Fixed-term / temporary' => 'fixed-term-temporary',
        'Freelance' => 'freelance',
    ];

    public const EXPERIENCE = [
        '0 - 1' => '0-1',
        '1 - 3' => '1-3',
        '3 - 5' => '3-5',
        '5 - 10' => '5-10',
        '10+' => '10+',
    ];

    public const WORK_FROM_HOME = [
        'Unknown' => 'unknown',
        'Occasional remote' => 'occasional-remote',
        'Hybrid remote' => 'hybrid-remote',
        'Open to full remote' => 'open-to-full-remote',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable:true)]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column(length: 150)]
    private ?string $contract = null;

    #[ORM\Column(length: 100)]
    private ?string $workFromHome = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 150)]
    private ?string $experience = null;

    #[ORM\Column]
    private ?int $minSalary = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxSalary = null;

    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'offers')]
    private Collection $skills;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: Application::class)]
    private Collection $applications;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $interviewProcess = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'offers', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize:'2M',
        mimeTypes: ['image/jpeg', 'image/png','image/jpg'],
        mimeTypesMessage:'Your image should be a jpeg, jpg or png'
    )]
    private ?File $offerPicture = null;

    #[ORM\ManyToMany(targetEntity: Candidate::class, inversedBy: 'favoriteOffers')]
    private Collection $favorites;

    #[ORM\Column(nullable: true)]
    private ?int $number = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column]
    private ?bool $archived = false;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;
        return $this;
    }

    public function getContract(): ?string
    {
        return $this->contract;
    }
    public function setContract(?string $contract): self
    {
        $this->contract = $contract;
        return $this;
    }

    public function getWorkFromHome(): ?string
    {
        return $this->workFromHome;
    }

    public function setWorkFromHome(?string $workFromHome): self
    {
        $this->workFromHome = $workFromHome;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
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

    public function getMinSalary(): ?int
    {
        return $this->minSalary;
    }

    public function setMinSalary(?int $minSalary): self
    {
        $this->minSalary = $minSalary;
        return $this;
    }

    public function getMaxSalary(): ?int
    {
        return $this->maxSalary;
    }

    public function setMaxSalary(int $maxSalary): self
    {
        $this->maxSalary = $maxSalary;
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
            $application->setOffer($this);
        }


        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getOffer() === $this) {
                $application->setOffer(null);
            }
        }

        return $this;
    }

    public function getInterviewProcess(): ?string
    {
        return $this->interviewProcess;
    }

    public function setInterviewProcess(string $interviewProcess): self
    {
        $this->interviewProcess = $interviewProcess;
        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return Collection<int, Candidate>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Candidate $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
        }

        return $this;
    }


    public function removeFavorite(Candidate $favorite): self
    {
        $this->favorites->removeElement($favorite);


        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;
        return $this;
    }

    public function setOfferPicture(File $image = null): Offer
    {
        $this->offerPicture = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    public function getOfferPicture(): ?File
    {
        return $this->offerPicture;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }
}
