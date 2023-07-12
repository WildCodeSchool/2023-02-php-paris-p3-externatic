<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use ArrayAccess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    public const SKILLS = [
        ['name' => 'PHP', 'type' => 'hard'],
        ['name' => 'JS', 'type' => 'hard'],
        ['name' => 'JAVA', 'type' => 'hard'],
        ['name' => 'Windev', 'type' => 'hard'],
        ['name' => 'html', 'type' => 'hard'],
        ['name' => 'CSS', 'type' => 'hard'],
        ['name' => 'PHP1', 'type' => 'hard'],
        ['name' => 'JS1', 'type' => 'hard'],
        ['name' => 'full of idea', 'type' => 'soft'],
        ['name' => 'alert', 'type' => 'soft'],
        ['name' => 'smiling', 'type' => 'soft'],
        ['name' => 'nice', 'type' => 'soft'],
        ['name' => 'inventive', 'type' => 'soft'],
        ['name' => 'perfectionist', 'type' => 'soft'],
        ['name' => 'full of idea1', 'type' => 'soft'],
        ['name' => 'alert1', 'type' => 'soft'],
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\ManyToMany(targetEntity: Candidate::class, inversedBy: 'skills')]
    private Collection $candidates;

    #[ORM\ManyToMany(targetEntity: Offer::class, inversedBy: 'skills')]
    private Collection $offers;

    public function __construct()
    {
        $this->candidates = new ArrayCollection();
        $this->offers = new ArrayCollection();
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

    /**
     * @return Collection<int, Candidate>
     */
    public function getCandidate(): Collection
    {
        return $this->candidates;
    }

    public function addCandidate(Candidate $candidate): self
    {
        if (!$this->candidates->contains($candidate)) {
            $this->candidates->add($candidate);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): self
    {
        $this->candidates->removeElement($candidate);

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
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        $this->offers->removeElement($offer);

        return $this;
    }
}
