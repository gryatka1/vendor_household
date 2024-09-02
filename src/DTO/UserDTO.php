<?php

namespace VendorHousehold\DTO;

use JsonSerializable;

class UserDTO implements JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
