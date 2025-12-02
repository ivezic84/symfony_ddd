<?php

namespace App\UI\Http\Controller\User;

use App\Application\User\DTO\UserDTO;
use App\Application\User\Service\UserService;
use App\Infrastructure\ORM\User\UserEntity;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "User")]
#[Route('/api/user')]
class UserController extends AbstractController
{

    public function __construct(private UserService $userService)
    {
    }


    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] UserDTO $userDTO): JsonResponse
    {
        $user = $this->userService->createUser($userDTO);
        return new JsonResponse(['id' => $user->getId()], 201);
    }


    #[Route('/{id}', methods: ['PUT'])]
    public function update(UserEntity $userEntity, #[MapRequestPayload] UserDTO $userDTO): JsonResponse
    {
        $this->userService->updateUser($userEntity->toDomain(), $userDTO);
        return new JsonResponse(null, 200);
    }


    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(UserEntity $userEntity): JsonResponse
    {
        $this->userService->deleteUser($userEntity->toDomain());
        return new JsonResponse(null, 204);
    }

}
