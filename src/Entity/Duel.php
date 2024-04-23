<?php

namespace App\Entity;

use App\Repository\DuelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DuelRepository::class)]
class Duel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    /**
     * @var Collection<int, Bet>
     */
    #[ORM\OneToMany(targetEntity: Bet::class, mappedBy: 'duel', orphanRemoval: true)]
    private Collection $bets;

    #[ORM\ManyToOne(inversedBy: 'duels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fighter $fighter_1 = null;

    #[ORM\ManyToOne(inversedBy: 'duels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fighter $fighter_2 = null;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Bet>
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): static
    {
        if (!$this->bets->contains($bet)) {
            $this->bets->add($bet);
            $bet->setDuel($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): static
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getDuel() === $this) {
                $bet->setDuel(null);
            }
        }

        return $this;
    }

    public function getFighter1(): ?Fighter
    {
        return $this->fighter_1;
    }

    public function setFighter1(?Fighter $fighter_1): static
    {
        $this->fighter_1 = $fighter_1;

        return $this;
    }

    public function getFighter2(): ?Fighter
    {
        return $this->fighter_2;
    }

    public function setFighter2(?Fighter $fighter_2): static
    {
        $this->fighter_2 = $fighter_2;

        return $this;
    }
}