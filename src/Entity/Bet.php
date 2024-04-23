<?php

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BetRepository::class)]
class Bet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $bet_value = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Duel $duel = null;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fighter $fighter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBetValue(): ?float
    {
        return $this->bet_value;
    }

    public function setBetValue(float $bet_value): static
    {
        $this->bet_value = $bet_value;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDuel(): ?Duel
    {
        return $this->duel;
    }

    public function setDuel(?Duel $duel): static
    {
        $this->duel = $duel;

        return $this;
    }

    public function getFighter(): ?Fighter
    {
        return $this->fighter;
    }

    public function setFighter(?Fighter $fighter): static
    {
        $this->fighter = $fighter;

        return $this;
    }
}
