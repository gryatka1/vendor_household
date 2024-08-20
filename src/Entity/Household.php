<?php

namespace VendorHousehold\Entity;

use VendorHousehold\Enum\HouseholdType;
use VendorHousehold\DTO\HouseholdDTO;
use Household\DTO\AsDTOInterface;
use VendorHousehold\Entity\Trait\CreatedAt;
use VendorHousehold\Entity\Trait\SoftDelete;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: '`household`')]
class Household implements AsDTOInterface
{
    use CreatedAt;
    use SoftDelete;

    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $type;

    // many to many with users
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'households')]
    private Collection $users;

    public function __construct(HouseholdType $type, User $user)
    {
        $this->createdAt = new DateTimeImmutable();
        $this->type = $type->value;
        $this->users = new ArrayCollection();

        $this->users->add($user);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addHousehold($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeHousehold($this);
        }

        return $this;
    }

    public static function asDTO(AsDTOInterface $household): HouseholdDTO
    {
        return new HouseholdDTO(
            $household->getId(),
            $household->getType(),
            $household->getUsers()->map(fn(User $user) => User::asDTO($user))
        );
    }
}