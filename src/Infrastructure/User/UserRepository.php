<?php

namespace App\Infrastructure\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{

    public function __construct(private EntityManagerInterface $em) {}


    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function delete(User $user): void
    {
        $user->delete();
        $this->em->persist($user);
        $this->em->flush();
    }

    public function findById(int $id): ?User
    {
        return $this->em->getRepository(User::class)->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['email.value' => strtolower($email)]);
    }

}
