<?php

namespace VendorHousehold\DTO;

use VendorHousehold\DTO\Traits\JsonSerializableTrait;
use Household\DTO\DTOInterface;
use Doctrine\Common\Collections\Collection;

class HouseholdDTO implements DTOInterface
{
    use JsonSerializableTrait;

    public function __construct(
        private readonly int $id,
        private readonly string $type,
        private readonly Collection $users,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /** @return Collection<UserDTO> */
    public function getUsers(): Collection
    {
        return $this->users;
    }
}
