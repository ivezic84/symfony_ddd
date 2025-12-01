<?php

namespace App\Domain\User\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Email
{
    #[ORM\Column(type: "string", nullable: true)]
    private ?string $value = null;

    public function __construct(?string $email)
    {
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email");
        }
        $this->value = $email ? strtolower($email) : null;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function equals(Email $other): bool
    {
        return $this->value === $other->value();
    }

}
