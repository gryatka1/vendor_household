<?php

namespace VendorHousehold\DTO;

use VendorHousehold\DTO\Traits\JsonSerializableTrait;
use Household\DTO\DTOInterface;

class UserDTO implements DTOInterface
{
    use JsonSerializableTrait;

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
}
