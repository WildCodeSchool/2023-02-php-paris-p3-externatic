<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'application', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidate $user = null;

    #[ORM\OneToOne(inversedBy: 'application', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offer $offer = null;

    #[ORM\Column]
    private ?bool $isFavorite = null;

    #[ORM\Column(length: 100)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $applicationAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Candidate
    {
        return $this->user;
    }

    public function setUser(Candidate $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function isIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getApplicationAt(): ?\DateTimeInterface
    {
        return $this->applicationAt;
    }

    public function setApplicationAt(\DateTimeInterface $applicationAt): self
    {
        $this->applicationAt = $applicationAt;

        return $this;
    }
}
