<?php

namespace App\Domain\User\Entity;

use App\Domain\Common\BaseEntity;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\ZipCode;
use App\Infrastructure\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends BaseEntity
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


    public function updateName(string $firstName, string $lastName): void
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function updateEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function __construct(string $firstName, string $lastName, Email $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function updateContactInfo(?string $address, ?string $city, ?ZipCode $zip, ?string $phone): void
    {
        $this->address = $address;
        $this->city = $city;
        $this->zip = $zip;
        $this->phone = $phone;
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email;
    }


    public function delete(): void
    {
        $this->deleted = true;
    }

}
