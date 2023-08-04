<?php

namespace App\Entity;

use App\Repository\EstablishmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstablishmentRepository::class)]
class Establishment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: false)]
    private ?string $siteName = null;

    #[ORM\OneToMany(mappedBy: 'establishment', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'establishment', targetEntity: Car::class)]
    private Collection $cars;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->cars = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getSiteName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(?string $siteName): Establishment
    {
        $this->siteName = $siteName;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(?User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setEstablishment($this);
        }
        return $this;
    }

    public function removeUser(?User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getEstablishment() === $this) {
                $user->setEstablishment(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setEstablishment($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getEstablishment() === $this) {
                $car->setEstablishment(null);
            }
        }

        return $this;
    }
}
