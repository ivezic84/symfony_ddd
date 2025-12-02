<?php

namespace App\Application\User\Service;

use App\Application\User\DTO\UserDTO;
use App\Domain\User\Entity\DomainUser;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\ValueObject\Email;

class UserService
{

    public function __construct(private UserRepositoryInterface $repository)
    {
    }


    public function createUser(UserDTO $userDTO): DomainUser
    {
        $emailVO = new Email($userDTO->email);
        $user = new DomainUser($userDTO->firstName, $userDTO->lastName, $emailVO);
        $user->updateContactInfo($userDTO->address, $userDTO->city, $userDTO->zip, $userDTO->phone);
        $this->repository->save($user);

        return $user;
    }

    public function updateUser(DomainUser $user, UserDTO $userDTO): void
    {
        $emailVO = new Email($userDTO->email);
        $user->changeEmail($emailVO);
        $user->updateName($userDTO->firstName, $userDTO->lastName);
        $user->updateContactInfo($userDTO->address, $userDTO->city, $userDTO->zip, $userDTO->phone);
        $this->repository->save($user);
    }

    public function deleteUser(DomainUser $user): void
    {
        $this->repository->delete($user);
    }

}
