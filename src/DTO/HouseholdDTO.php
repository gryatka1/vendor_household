<?php

namespace VendorHousehold\DTO;

use JsonSerializable;
use Doctrine\Common\Collections\Collection;

class HouseholdDTO implements JsonSerializable
{
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

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
