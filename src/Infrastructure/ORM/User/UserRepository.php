<?php

namespace App\Infrastructure\ORM\User;

use App\Domain\User\Entity\DomainUser;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(private EntityManagerInterface $em) {}


    public function save(DomainUser $user): void
    {
        $entity = UserEntity::fromDomain($user);
        $this->em->persist($entity);
        $this->em->flush();
    }


    public function delete(DomainUser $user): void
    {
        $entity = UserEntity::fromDomain($user);
        $this->em->remove($entity);
        $this->em->flush();
    }


    public function findById(int $id): ?DomainUser
    {
        $entity = $this->em->getRepository(UserEntity::class)->find($id);
        return $entity?->toDomain();
    }

    public function getEntityById(int $id): ?UserEntity
    {
        return $this->em->getRepository(UserEntity::class)->find($id);
    }


}
