<?php

namespace App\Domain\User\Entity;

use App\Domain\User\ValueObject\Email;

final class DomainUser
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


    public function setId(int $id): void
    {
        $this->id = $id;
    }

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


    // Factory method for reconstruction from database
    public static function fromDatabase(
        int $id,
        string $firstName,
        string $lastName,
        Email $email,
        ?string $address = null,
        ?string $city = null,
        ?string $zip = null,
        ?string $phone = null,
        bool $deleted = false
    ): self {
        $user = new self($firstName, $lastName, $email);
        $user->id = $id;
        $user->address = $address;
        $user->city = $city;
        $user->zip = $zip;
        $user->phone = $phone;
        $user->deleted = $deleted;
        return $user;
    }

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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): Email
    {
        return $this->email;
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

    public function isDeleted(): bool
    {
        return $this->deleted;
    }
}
