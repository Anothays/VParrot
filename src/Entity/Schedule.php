<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = 1;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $openedDays = [];

    #[ORM\OneToMany(mappedBy: 'schedule', targetEntity: Garage::class)]
    private Collection $garages;




    public function __construct()
    {
        $this->garages = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Schedule
     */
    public function setId(?int $id): Schedule
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getOpenedDays(): array
    {
        return $this->openedDays;
    }

    /**
     * @param array $openedDays
     */
    public function setOpenedDays(array $openedDays): self
    {
        $this->openedDays = $openedDays;
        return $this;
    }


    /**
     * @return Collection<int, Garage>
     */
    public function getGarages(): Collection
    {
        return $this->garages;
    }

    public function addGarage(Garage $garage): self
    {
        if (!$this->garages->contains($garage)) {
            $this->garages->add($garage);
            $garage->setSchedule($this);
        }

        return $this;
    }

    public function removeGarage(Garage $garage): self
    {
        if ($this->garages->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getSchedule() === $this) {
                $garage->setSchedule(null);
            }
        }

        return $this;
    }



}