<?php

namespace App\Infrastructure\ORM\User;

use App\Domain\Common\BaseEntity;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\Email;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class UserEntity extends BaseEntity
{

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $zip = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(name: 'birthdate', type: 'date', nullable: true)]
    private ?\DateTime $birthdate = null;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $deleted = false;

    #[ORM\Embedded(class: Email::class, columnPrefix: "email_")]
    private ?Email $email = null;


    // --------- Mapping from Domain ---------
    public static function fromDomain(User $user): self
    {
        $entity = new self();
        if ($user->getId()) {
            $entity->id = $user->getId();
        }

        $entity->firstName = $user->getFirstName();
        $entity->lastName = $user->getLastName();
        $entity->email = $user->getEmail()->value();
        return $entity;
    }

    // --------- Mapping to Domain ---------
    public function toDomain(): User
    {
        return new User(
            $this->firstName,
            $this->lastName,
            new Email($this->email)
        );
    }

}
