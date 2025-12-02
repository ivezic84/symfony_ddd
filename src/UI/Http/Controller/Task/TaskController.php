<?php

namespace App\UI\Http\Controller\Task;


use App\Application\Task\DTO\TaskDTO;
use App\Application\Task\Service\TaskService;
use App\Infrastructure\ORM\Task\TaskEntity;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Task")]
#[Route('/api/task')]
class TaskController extends AbstractController
{
    public function __construct(private TaskService $taskService) {}

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] TaskDTO $taskDTO): JsonResponse
    {
        $task = $this->taskService->createTask($taskDTO);
        return new JsonResponse(['id' => $task->getId()], 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(TaskEntity $taskEntity, #[MapRequestPayload] TaskDTO $taskDTO): JsonResponse
    {
        $this->taskService->updateTask($taskEntity->toDomain(), $taskDTO);
        return new JsonResponse(null, 200);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(TaskEntity $taskEntity): JsonResponse
    {
        $this->taskService->deleteTask($taskEntity->toDomain());
        return new JsonResponse(null, 204);
    }
}
