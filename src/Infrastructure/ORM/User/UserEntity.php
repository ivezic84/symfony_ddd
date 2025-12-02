<?php

namespace App\Infrastructure\ORM\User;

use App\Domain\Common\BaseEntity;
use App\Domain\User\Entity\DomainUser;
use App\Domain\User\ValueObject\Email;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('email')]
#[ORM\Table(name: 'user')]
#[ORM\Entity]
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
    public static function fromDomain(DomainUser $user): self
    {
        $entity = new self();
        if ($user->getId()) {
            $entity->id = $user->getId();
        }

        $entity->firstName = $user->getFirstName();
        $entity->lastName = $user->getLastName();
        $entity->email = $user->getEmail();
        $entity->address = $user->getAddress();
        $entity->city = $user->getCity();
        $entity->zip = $user->getZip();
        $entity->phone = $user->getPhone();
        return $entity;
    }

    // --------- Mapping to Domain ---------
    public function toDomain(): DomainUser
    {
        $user = new DomainUser(
            $this->firstName,
            $this->lastName,
            $this->email
        );

        $user->setId($this->id);

        return $user;
    }


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function getEmail(): ?Email
    {
        return $this->email;
    }

}
