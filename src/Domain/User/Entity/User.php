<?php

namespace App\Domain\User\Entity;

use App\Domain\User\ValueObject\Email;

final class User
{
    private ?int $id = null;
    private string $firstName;
    private string $lastName;
    private Email $email;
    private ?string $address = null;
    private ?string $city = null;
    private ?string $zip = null;
    private ?string $phone = null;
    private bool $deleted = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct(string $firstName, string $lastName, Email $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    // Domen metode
    public function updateName(string $firstName, string $lastName): void
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function updateContactInfo(?string $address, ?string $city, ?string $zip, ?string $phone): void
    {
        $this->address = $address;
        $this->city = $city;
        $this->zip = $zip;
        $this->phone = $phone;
    }

    public function delete(): void
    {
        $this->deleted = true;
    }

    // Getters
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getEmail(): Email { return $this->email; }
}
