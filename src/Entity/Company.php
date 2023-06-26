<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    public const COMPANY_SECTOR = [
        'Software' => 'Software',
        'Data' => 'Data',
        'Cloud service' => 'Cloud service',
        'Cyber Security' => 'Cyber Security',
        'Mobile' => 'Mobile',
        'AI / Machine Learning' => 'AI / Machine Learning',
        'Connected Object' => 'Connected Object',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column(length: 150)]
    private ?string $sector = null;

    #[ORM\Column(type: Types::TEXT, length: 300)]
    private ?string $presentation = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\OneToOne(inversedBy: 'company', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Offer::class)]
    private Collection $offers;

    #[ORM\OneToMany(mappedBy: 'favorite', targetEntity: Candidate::class)]
    private Collection $favoriteCandidates;

    #[ORM\ManyToOne(inversedBy: 'favoriteCompanies')]
    private ?Candidate $favorite = null;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->favoriteCandidates = new ArrayCollection();
    }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSector(): ?string
    {
        return $this->sector;
    }

    public function setSector(string $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getLogo(): ?string
    {
        return 'uploads/companyLogos/' . $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

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
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
            $offer->setCompany($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getCompany() === $this) {
                $offer->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Candidate>
     */
    public function getFavoriteCandidates(): Collection
    {
        return $this->favoriteCandidates;
    }

    public function addFavoriteCandidate(Candidate $favoriteCandidate): self
    {
        if (!$this->favoriteCandidates->contains($favoriteCandidate)) {
            $this->favoriteCandidates->add($favoriteCandidate);
            $favoriteCandidate->setFavorite($this);
        }

        return $this;
    }

    public function removeFavoriteCandidate(Candidate $favoriteCandidate): self
    {
        if ($this->favoriteCandidates->removeElement($favoriteCandidate)) {
            // set the owning side to null (unless already changed)
            if ($favoriteCandidate->getFavorite() === $this) {
                $favoriteCandidate->setFavorite(null);
            }
        }

        return $this;
    }

    public function getFavorite(): ?Candidate
    {
        return $this->favorite;
    }

    public function setFavorite(?Candidate $favorite): self
    {
        $this->favorite = $favorite;

        return $this;
    }
}
