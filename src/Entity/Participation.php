<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationRepository::class)
 */
class Participation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isBench;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="participations")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="participations")
     */
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsBench(): ?bool
    {
        return $this->isBench;
    }

    public function setIsBench(?bool $isBench): self
    {
        $this->isBench = $isBench;

        return $this;
    }

    public function getEvent(): ?event
    {
        return $this->event;
    }

    public function setEvent(?event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getPlayer(): ?player
    {
        return $this->player;
    }

    public function setPlayer(?player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
