<?php

namespace App\Entity;

use App\Repository\RaidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RaidRepository::class)
 */
class Raid
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
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="raid")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="raid")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $item;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->item = new ArrayCollection();
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

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addRaid($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeRaid($this);
        }

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
            $item->setRaid($this);
        }

        return $this;
    }

    public function removeItem(item $item): self
    {
        if ($this->item->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getRaid() === $this) {
                $item->setRaid(null);
            }
        }

        return $this;
    }

}