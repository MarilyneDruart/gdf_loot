<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Assert\NotNull
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $log;

    /**
     * @ORM\ManyToMany(targetEntity=Raid::class, inversedBy="events")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $raid;

    /**
     * @ORM\ManyToMany(targetEntity=Item::class, inversedBy="events")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $item;

    /**
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="event")
     */
    private $participations;

    /**
     * @ORM\OneToMany(targetEntity=LootHistory::class, mappedBy="event")
     */
    private $lootHistories;

    public function __construct()
    {
        $this->raid = new ArrayCollection();
        $this->item = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->lootHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
        
    }

    public function setDate(?\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLog(): ?string
    {
        return $this->log;
    }

    public function setLog(?string $log): self
    {
        $this->log = $log;

        return $this;
    }

    /**
     * @return Collection<int, raid>
     */
    public function getRaid(): Collection
    {
        return $this->raid;
    }

    public function addRaid(raid $raid): self
    {
        if (!$this->raid->contains($raid)) {
            $this->raid[] = $raid;
        }

        return $this;
    }

    public function removeRaid(raid $raid): self
    {
        $this->raid->removeElement($raid);

        return $this;
    }

    /**
     * @return Collection<int, item>
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    public function addItem(item $item): self
    {
        if (!$this->item->contains($item)) {
            $this->item[] = $item;
        }

        return $this;
    }

    public function removeItem(item $item): self
    {
        $this->item->removeElement($item);

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
            $participation->setEvent($this);
        }

        return $this;
    }

    public function removeParticipations(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getEvent() === $this) {
                $participation->setEvent(null);
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
            $lootHistory->setEvent($this);
        }

        return $this;
    }

    public function removeLootHistory(LootHistory $lootHistory): self
    {
        if ($this->lootHistories->removeElement($lootHistory)) {
            // set the owning side to null (unless already changed)
            if ($lootHistory->getEvent() === $this) {
                $lootHistory->setEvent(null);
            }
        }

        return $this;
    }
}
