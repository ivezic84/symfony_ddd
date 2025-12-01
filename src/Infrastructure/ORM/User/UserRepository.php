<?php

namespace App\Infrastructure\ORM\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{

    public function __construct(private EntityManagerInterface $em) {}


    public function save(User $user): void
    {
        $entity = UserEntity::fromDomain($user);
        $this->em->persist($entity);
        $this->em->flush();
    }


    public function delete(User $user): void
    {
        $entity = UserEntity::fromDomain($user);
        $this->em->remove($entity);
        $this->em->flush();
    }


    public function findById(int $id): ?User
    {
        $entity = $this->em->getRepository(UserEntity::class)->find($id);
        return $entity?->toDomain();
    }

}
