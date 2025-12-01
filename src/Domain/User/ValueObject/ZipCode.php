<?php

namespace App\Domain\User\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class ZipCode
{
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $value = null;

    public function __construct(?string $zip)
    {
        if ($zip && !preg_match('/^\d{5}$/', $zip)) {
            throw new \InvalidArgumentException("Invalid zip code");
        }
        $this->value = $zip;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function equals(ZipCode $other): bool
    {
        return $this->value === $other->value();
    }
}
