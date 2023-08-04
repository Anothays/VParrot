<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $constructor = null;

    #[ORM\Column(length: 50)]
    private ?string $model = null;

    #[ORM\Column(length: 50)]
    private ?string $engine = null;

    #[ORM\Column(length: 9)]
    private ?string $licensePlate = null;

    #[ORM\Column]
    private ?int $registrationYear = null;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: "datetime", columnDefinition: "DATETIME on update CURRENT_TIMESTAMP")]
    private ?\DateTime $modifiedAt = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Photo::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $photos;

    #[ORM\OneToMany(mappedBy: 'car_id', targetEntity: ContactMessage::class)]
    private Collection $contactMessages;

    #[ORM\ManyToOne(inversedBy: 'createdCars')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?Establishment $establishment = null;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $this->modifiedAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->photos = new ArrayCollection();
        $this->contactMessages = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getConstructor() . ' ' . $this->getModel();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConstructor(): ?string
    {
        return $this->constructor;
    }

    public function setConstructor(?string $constructor): Car
    {
        $this->constructor = $constructor;
        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): Car
    {
        $this->model = $model;
        return $this;
    }



    public function getRegistrationYear(): ?int
    {
        return $this->registrationYear;
    }

    public function setRegistrationYear(int $registrationYear): self
    {
        $this->registrationYear = $registrationYear;
        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): ?\DateTime
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTime $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setCar($this);
        }
        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
//            if ($photo->getCar() === $this) {
//                $photo->setCar(null);
//            }
        }
        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(?string $licensePlate): Car
    {
        $this->licensePlate = $licensePlate;
        return $this;
    }

    public function getContactMessages(): Collection
    {
        return $this->contactMessages;
    }

    public function addContact(ContactMessage $message): self
    {
        if (!$this->contactMessages->contains($message)) {
            $this->contactMessages->add($message);
            $message->setCar($this);
        }

        return $this;
    }

    public function removeContact(ContactMessage $message): self
    {
        if ($this->contactMessages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getCar() === $this) {
                $message->setCar(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getEngine(): ?string
    {
        return $this->engine;
    }

    public function setEngine(?string $engine): Car
    {
        $this->engine = $engine;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(?Establishment $establishment): self
    {
        $this->establishment = $establishment;

        return $this;
    }

    // fonction de test pour le crudController associé

//    public function getfilenames(): array
//    {
//        $tab = [];
//        foreach ($this->getPhotos() as $photos) {
//            $tab[] = $this->getLicensePlate() .'/'. $photos->getfilename();
//        }
//        return $tab;
//    }

}
