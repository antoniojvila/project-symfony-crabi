<?php

namespace App\Mapper;

use App\DTO\UserDTO;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserMapper
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function dtoToEntity(UserDTO $userDTO): User
    {
        $user = new User();
        $user->setEmail($userDTO->getEmail());
        $user->setPassword($this->passwordHasher->hashPassword($user, $userDTO->getPassword()));
        $user->setFirstName($userDTO->getFirstName());
        $user->setLastName($userDTO->getLastName());

        return $user;
    }
}