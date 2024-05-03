<?php

namespace App\Entity;

use App\Repository\FighterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FighterRepository::class)]
#[Vich\Uploadable]
class Fighter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'The fighter\'s last name must be at least {{ limit }} characters long',
        maxMessage: 'The fighter\'s last name cannot be longer than {{ limit }} characters'
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'The fighter\'s first name must be at least {{ limit }} characters long',
        maxMessage: 'The fighter\'s first name cannot be longer than {{ limit }} characters'
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'The fighter\'s pseudo must be at least {{ limit }} characters long',
        maxMessage: 'The fighter\'s pseudo cannot be longer than {{ limit }} characters'
    )]
    private ?string $pseudo = null;

    #[ORM\Column]
    #[Assert\LessThanOrEqual(
        value: 20,
        message: 'The level must be smaller than 20'
    )]
    #[Assert\GreaterThanOrEqual(
        value: 1,
        message: 'The level must be higher than 1'
    )]
    private ?int $level = null;

    /**
     * @var Collection<int, Bet>
     */
    #[ORM\OneToMany(targetEntity: Bet::class, mappedBy: 'fighter', orphanRemoval: true)]
    private Collection $bets;

    /**
     * @var Collection<int, Duel>
     */
    #[ORM\OneToMany(targetEntity: Duel::class, mappedBy: 'fighter_1', orphanRemoval: true)]
    private Collection $duels;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'fighter_picture', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'The number of victory must be higher than 0'
    )]
    private ?int $victory = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'The number of defeat must be higher than 0'
    )]
    private ?int $defeat = null;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
        $this->duels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

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
            $bet->setFighter($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): static
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getFighter() === $this) {
                $bet->setFighter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Duel>
     */
    public function getDuels(): Collection
    {
        return $this->duels;
    }

    public function addDuel(Duel $duel): static
    {
        if (!$this->duels->contains($duel)) {
            $this->duels->add($duel);
            $duel->setFighter1($this);
        }

        return $this;
    }

    public function removeDuel(Duel $duel): static
    {
        if ($this->duels->removeElement($duel)) {
            // set the owning side to null (unless already changed)
            if ($duel->getFighter1() === $this) {
                $duel->setFighter1(null);
            }
        }

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getVictory(): ?int
    {
        return $this->victory;
    }

    public function setVictory(int $victory): static
    {
        $this->victory = $victory;

        return $this;
    }

    public function getDefeat(): ?int
    {
        return $this->defeat;
    }

    public function setDefeat(int $defeat): static
    {
        $this->defeat = $defeat;

        return $this;
    }
}
