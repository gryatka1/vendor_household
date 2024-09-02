<?php

namespace VendorHousehold\Factory;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use VendorHousehold\Entity\User;

class UserFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    public function create(string $email, string $password): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        $user
            ->setEmail($email)
            ->setPassword($hashedPassword)
            ->setRoles(['someRole']);

        return $user;
    }
}