<?php

namespace App\Entity;

use App\Repository\TestimonialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TestimonialRepository::class)]
class Testimonial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['testimonial'])]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['testimonial'])]
    private ?string $comment = null;

    #[ORM\Column(length: 1)]
    #[Groups(['testimonial'])]
    private ?int $note = null;

    #[ORM\Column]
    private ?bool $isApproved = false;

    #[ORM\Column]
    #[Groups(['testimonial'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'createdTestimonials')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?User $createdBy = null;

    #[ORM\Column(type: "datetime", columnDefinition: "DATETIME on update CURRENT_TIMESTAMP")]
    private ?\DateTime $modifiedAt = null;

    #[ORM\ManyToOne(inversedBy: 'approvedTestimonials')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?User $approvedBy = null;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $this->modifiedAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getIsApproved(): ?bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $bool): self
    {
        $this->isApproved = $bool;

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

    public function setModifiedAt(\DateTime $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getApprovedBy(): ?User
    {
        return $this->approvedBy;
    }

    public function setApprovedBy(?User $user): self
    {
        $this->approvedBy = $user;

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

}
