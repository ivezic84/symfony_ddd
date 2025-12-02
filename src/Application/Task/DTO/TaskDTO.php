<?php

namespace App\Application\Task\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class TaskDTO
{
    #[Assert\Type('integer')]
    public int $userId;

    #[Assert\NotBlank(message: "Title is required")]
    #[Assert\Length(max: 50)]
    public string $title;

    #[Assert\Type('string')]
    public ?string $description = null;
}
