<?php

namespace VendorHousehold\DTO\Factory;

use VendorHousehold\DTO\HouseholdDTO;
use VendorHousehold\Entity\Household;
use VendorHousehold\Entity\User;
use VendorHousehold\Factory\UserFactory;

class HouseholdDTOFactory
{
    public function __construct(
        private readonly UserFactory $userFactory,
    )
    {
    }


    public function create(Household $household): HouseholdDTO
    {
        return new HouseholdDTO(
            $household->getId(),
            $household->getType(),
            $household->getUsers()->map(fn(User $user) => $this->userFactory->createDTO($user))
        );
    }
}
