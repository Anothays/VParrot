<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Day = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $openMorningTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $openAfternoonTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDay(): ?string
    {
        return $this->Day;
    }

    public function setDay(?string $Day): self
    {
        $this->Day = $Day;

        return $this;
    }

    public function getOpenMorningTime(): ?string
    {
        return $this->openMorningTime;
    }

    public function setOpenMorningTime(?string $openMorningTime): self
    {
        $this->openMorningTime = $openMorningTime;

        return $this;
    }

    public function getOpenAfternoonTime(): ?string
    {
        return $this->openAfternoonTime;
    }

    public function setOpenAfternoonTime(?string $openAfternoonTime): self
    {
        $this->openAfternoonTime = $openAfternoonTime;

        return $this;
    }
}
