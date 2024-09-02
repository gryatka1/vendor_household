<?php

namespace VendorHousehold\Factory;

use VendorHousehold\Entity\Household;
use VendorHousehold\Entity\User;
use VendorHousehold\Enum\HouseholdType;

class HouseholdFactory
{
    public function create(HouseholdType $type, User $user): Household
    {
        return new Household(
            $type,
            $user
        );
    }
}
