<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[Vich\Uploadable]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'services', fileNameProperty: 'imageName')]
    #[Assert\Image()]
    private ?File $imageFile = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: "datetime", columnDefinition: "DATETIME on update CURRENT_TIMESTAMP")]
    private ?\DateTime $modifiedAt = null;

    #[ORM\ManyToOne(inversedBy: 'createdServices')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?User $createdBy = null;

    #[ORM\Column()]
    private ?bool $published = false;

    #[ORM\ManyToMany(targetEntity: Garage::class, inversedBy: 'services')]
    private Collection $garage;




    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $this->modifiedAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->garage = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        if ($imageFile !== null) {
            $this->setModifiedAt(new \DateTime());
        }
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): ?\DateTime
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTime $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $user): self
    {
        $this->createdBy = $user;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return Collection<int, Garage>
     */
    public function getGarage(): Collection
    {
        return $this->garage;
    }

    public function addGarage(Garage $garage): self
    {
        if (!$this->garage->contains($garage)) {
            $this->garage->add($garage);
        }

        return $this;
    }

    public function removeGarage(Garage $garage): self
    {
        $this->garage->removeElement($garage);

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

}
