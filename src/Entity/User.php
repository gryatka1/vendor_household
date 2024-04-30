<?php

namespace ActiveUser\Entity;

use ActiveUser\Repository\UserRepository;
use Household\DTO\AsDTOInterface;
use ActiveUser\DTO\UserDTO;
use ActiveUser\Entity\Trait\CreatedAt;
use ActiveUser\Entity\Trait\SoftDelete;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, AsDTOInterface
{
    use CreatedAt;
    use SoftDelete;

    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    // many to many
    #[ORM\ManyToMany(targetEntity: Household::class, mappedBy: 'users')]
    private Collection $households;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->households = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getHouseholds(): Collection
    {
        return $this->households;
    }

    public function addHousehold(Household $household): static
    {
        if (!$this->households->contains($household)) {
            $this->households->add($household);
            $household->addUser($this);
        }

        return $this;
    }

    public function removeHousehold(Household $household): static
    {
        if ($this->households->removeElement($household)) {
            $household->removeUser($this);
        }

        return $this;
    }

    public static function asDTO(AsDTOInterface $user): UserDTO
    {
        return new UserDTO($user->getId(), $user->getEmail());
    }
}
