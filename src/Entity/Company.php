<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[Vich\Uploadable]
class Company implements Serializable
{
    public const COMPANY_SECTOR = [
        'Software' => 'software',
        'Data' => 'data',
        'Cloud service' => 'cloud-service',
        'Cyber Security' => 'cyber-security',
        'Mobile' => 'mobile',
        'AI / Machine Learning' => 'ai-machine-learning',
        'Connected Object' => 'connected-object',
    ];

    public const COMPANY_SIZE = [
        'between 0 and 10 employees',
        'between 10 and 50 employees',
        'between 50 and 250 employees',
        'between 250  and 2000 employees',
        '2000 + employees',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:50)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank]
    private ?string $size = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\NotBlank]
    private ?string $sector = null;

    #[ORM\Column(type: Types::TEXT, length: 300, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max:300)]
    private ?string $presentation = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $logo = null;

    #[Vich\UploadableField(mapping: 'companies', fileNameProperty: 'logo')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/jpg', 'image/png'],
        mimeTypesMessage:'Your logo should be a jpeg, jpg or png'
    )]
    private ?File $logoFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:30)]
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

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

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

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
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function setLogoFile(File $image = null): Company
    {
        $this->logoFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
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

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->logo,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->logo,
            ) = unserialize($serialized, array('allowed_classes' => false));
    }
}
