<?php

namespace App\Application\User\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class UserDTO
{

    #[Assert\NotBlank(message: "First name is required")]
    #[Assert\Length(max: 50)]
    public string $firstName;

    #[Assert\NotBlank(message: "Last name is required")]
    #[Assert\Length(max: 50)]
    public string $lastName;

    #[Assert\Length(max: 100)]
    public ?string $address = null;

    #[Assert\Length(max: 50)]
    public ?string $city = null;

    #[Assert\Regex(
        pattern: '/^\d{5}$/',
        message: "ZIP must be 5 digits"
    )]
    public ?string $zip = null;

    #[Assert\Length(max: 20)]
    public ?string $phone = null;

    #[Assert\Email(message: "Invalid email address")]
    public ?string $email = null;

}
