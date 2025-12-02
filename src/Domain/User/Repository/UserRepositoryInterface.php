<?php

namespace App\Domain\User\Repository;



use App\Domain\User\Entity\DomainUser;

interface UserRepositoryInterface
{
    public function save(DomainUser $user): void;
    public function delete(DomainUser $user): void;
    public function findById(int $id): ?DomainUser;

}
