<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $class;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $rank;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $isActif;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="player")
     */
    private $participations;

    /**
     * @ORM\OneToMany(targetEntity=LootHistory::class, mappedBy="player")
     */
    private $lootHistories;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->lootHistories = new ArrayCollection();
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

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function setRank(string $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function isIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRole(): ?role
    {
        return $this->role;
    }

    public function setRole(?role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipations(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setPlayer($this);
        }

        return $this;
    }

    public function removeParticipations(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getPlayer() === $this) {
                $participation->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LootHistory>
     */
    public function getLootHistories(): Collection
    {
        return $this->lootHistories;
    }

    public function addLootHistory(LootHistory $lootHistory): self
    {
        if (!$this->lootHistories->contains($lootHistory)) {
            $this->lootHistories[] = $lootHistory;
            $lootHistory->setPlayer($this);
        }

        return $this;
    }

    public function removeLootHistory(LootHistory $lootHistory): self
    {
        if ($this->lootHistories->removeElement($lootHistory)) {
            // set the owning side to null (unless already changed)
            if ($lootHistory->getPlayer() === $this) {
                $lootHistory->setPlayer(null);
            }
        }

        return $this;
    }
}
