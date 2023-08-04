<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/",
        message: 'Le mot de passe doit contenir au m inimum 12 caractères dont une minuscule, une majuscule, un chiffre, un caractère spéciale'
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\OneToMany(mappedBy: 'approvedBy', targetEntity: Testimonial::class)]
    private Collection $approvedTestimonials;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Testimonial::class)]
    private Collection $createdTestimonials;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Service::class)]
    private Collection $createdServices;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Establishment::class)]
    private Collection $createdEstablishments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Car::class)]
    private Collection $createdCars;

    public function __construct()
    {
        $this->approvedTestimonials = new ArrayCollection();
        $this->createdTestimonials = new ArrayCollection();
        $this->createdServices = new ArrayCollection();
        $this->createdEstablishments = new ArrayCollection();
        $this->createdCars = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->name . ' ' . $this->lastName;
    }

    /**
     * @return Collection<int, Testimonial>
     */
    public function getValidatedTestimonials(): Collection
    {
        return $this->approvedTestimonials;
    }

    public function addValidatedTestimonial(Testimonial $testimonial): self
    {
        if (!$this->approvedTestimonials->contains($testimonial)) {
            $this->approvedTestimonials->add($testimonial);
            $testimonial->setUser($this);
        }

        return $this;
    }

    public function removeValidatedTestimonial(Testimonial $testimonial): self
    {
        if ($this->approvedTestimonials->removeElement($testimonial)) {
            // set the owning side to null (unless already changed)
            if ($testimonial->getUser() === $this) {
                $testimonial->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Testimonial>
     */
    public function getCreatedTestimonials(): Collection
    {
        return $this->createdTestimonials;
    }

    public function addCreatedTestimonial(Testimonial $testimonial): self
    {
        if (!$this->createdTestimonials->contains($testimonial)) {
            $this->createdTestimonials->add($testimonial);
            $testimonial->setUser($this);
        }
        return $this;
    }

    public function removeCreatedTestimonial(Testimonial $testimonial): self
    {
        if ($this->createdTestimonials->removeElement($testimonial)) {
            // set the owning side to null (unless already changed)
            if ($testimonial->getUser() === $this) {
                $testimonial->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getCreatedServices(): Collection
    {
        return $this->createdServices;
    }

    public function addCreatedService(Service $createdService): self
    {
        if (!$this->createdServices->contains($createdService)) {
            $this->createdServices->add($createdService);
            $createdService->setUser($this);
        }

        return $this;
    }

    public function removeCreatedService(Service $createdService): self
    {
        if ($this->createdServices->removeElement($createdService)) {
            // set the owning side to null (unless already changed)
            if ($createdService->getUser() === $this) {
                $createdService->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Establishment>
     */
    public function getCreatedEstablishments(): Collection
    {
        return $this->createdEstablishments;
    }

    public function addCreatedEstablishment(Establishment $createdEstablishment): self
    {
        if (!$this->createdEstablishments->contains($createdEstablishment)) {
            $this->createdEstablishments->add($createdEstablishment);
            $createdEstablishment->setUser($this);
        }

        return $this;
    }

    public function removeCreatedEstablishment(Establishment $createdEstablishment): self
    {
        if ($this->createdEstablishments->removeElement($createdEstablishment)) {
            // set the owning side to null (unless already changed)
            if ($createdEstablishment->getUser() === $this) {
                $createdEstablishment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCreatedCars(): Collection
    {
        return $this->createdCars;
    }

    public function addCreatedCar(Car $createdCar): self
    {
        if (!$this->createdCars->contains($createdCar)) {
            $this->createdCars->add($createdCar);
            $createdCar->setUser($this);
        }

        return $this;
    }

    public function removeCreatedCar(Car $createdCar): self
    {
        if ($this->createdCars->removeElement($createdCar)) {
            // set the owning side to null (unless already changed)
            if ($createdCar->getUser() === $this) {
                $createdCar->setUser(null);
            }
        }

        return $this;
    }
}
