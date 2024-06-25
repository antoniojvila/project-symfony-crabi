<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserRepository extends ServiceEntityRepository
{
    private $baseRepository;

    public function __construct(ManagerRegistry $registry, BaseRepository $baseRepository)
    {
        parent::__construct($registry, User::class);
        $this->baseRepository = $baseRepository;
    }

    public function save(User $user): void
    {
        $this->baseRepository->save($user);
    }

    public function remove(User $user): void
    {
        $this->baseRepository->remove($user);
    }
}