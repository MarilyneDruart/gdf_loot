<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
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
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="item")
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity=Raid::class, inversedBy="item")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $raid;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $detail;

    /**
     * @ORM\ManyToMany(targetEntity=Slot::class, mappedBy="item")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $slots;

    /**
     * @ORM\OneToMany(targetEntity=LootHistory::class, mappedBy="item")
     */
    private $lootHistories;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->slots = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvents(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addItem($this);
        }

        return $this;
    }

    public function removeEvents(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeItem($this);
        }

        return $this;
    }

    public function getRaid(): ?Raid
    {
        return $this->raid;
    }

    public function setRaid(?Raid $raid): self
    {
        $this->raid = $raid;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return Collection<int, Slot>
     */
    public function getSlots(): Collection
    {
        return $this->slots;
    }

    public function addSlot(Slot $slot): self
    {
        if (!$this->slots->contains($slot)) {
            $this->slots[] = $slot;
            $slot->addItem($this);
        }

        return $this;
    }

    public function removeSlot(Slot $slot): self
    {
        if ($this->slots->removeElement($slot)) {
            $slot->removeItem($this);
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
            $lootHistory->setItem($this);
        }

        return $this;
    }

    public function removeLootHistory(LootHistory $lootHistory): self
    {
        if ($this->lootHistories->removeElement($lootHistory)) {
            // set the owning side to null (unless already changed)
            if ($lootHistory->getItem() === $this) {
                $lootHistory->setItem(null);
            }
        }

        return $this;
    }

}