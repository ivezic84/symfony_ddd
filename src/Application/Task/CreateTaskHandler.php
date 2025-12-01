<?php

namespace App\Application\Task;

use App\Domain\Task\Service\TaskCreator;

class CreateTaskHandler
{

    public function __construct(private TaskCreator $taskCreator)
    {
    }

    public function handle(string $title): void
    {
        $this->taskCreator->create($title);
    }

}
