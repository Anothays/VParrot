<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarsRepository::class)]
class Cars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 9)]
    private ?string $licensePlate = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $registrationYear = null;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: "datetime", columnDefinition: "DATETIME on update CURRENT_TIMESTAMP")]
    private ?\DateTime $modifiedAt = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Photos::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $photos;

    #[ORM\Column(type: 'string')]
    private ?string $engine = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $this->modifiedAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->photos = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getModel();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;
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


    /**
     * @return Collection<int, photos>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setCar($this);
        }
        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getCar() === $this) {
//                $photo->setCar(null);
            }
        }
        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(?string $licensePlate): Cars
    {
        $this->licensePlate = $licensePlate;
        return $this;
    }


    public function getEngine(): ?string
    {
        return $this->engine;
    }


    public function setEngine(?string $engine): self
    {
        $this->engine = $engine;
        return $this;
    }

//    public function getPhotosFilename() {
//        $photosFilename = [];
//        foreach ($this->getPhotos() as $photo) {
//            $photosFilename[] = $photo->getFilename();
//        }
//        return $photosFilename;
//    }
}
