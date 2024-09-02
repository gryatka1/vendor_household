<?php

namespace VendorHousehold\DTO\Factory;

use VendorHousehold\DTO\UserDTO;
use VendorHousehold\Entity\User;

class UserDTOFactory
{
    public function create(User $user): UserDTO
    {
        return new UserDTO(
            id: $user->getId(),
            email: $user->getEmail(),
        );
    }
}
