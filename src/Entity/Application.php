<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    public const STATUS_RECEIVED = "received";
    public const STATUS_INREVIEW = "in review";
    public const STATUS_ACCEPTED = "accepted";
    public const STATUS_REJECTED = "rejected";

    public const APPLICATION_STATUS = [
        self::STATUS_RECEIVED => self::STATUS_RECEIVED,
        self::STATUS_INREVIEW => self::STATUS_INREVIEW,
        self::STATUS_ACCEPTED => self::STATUS_ACCEPTED,
        self::STATUS_REJECTED => self::STATUS_REJECTED
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $status = null;

    #[ORM\Column(type:"datetime", options:["default" => "CURRENT_TIMESTAMP"])]
    private DateTime $createdAt;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidate $candidate = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offer $offer = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }
}
