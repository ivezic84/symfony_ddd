<?php

namespace App\UI\Http\Controller;

use App\Application\Task\CreateTaskHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    #[Route('/tasks', name: 'create_task', methods: ['POST'])]
    public function create(Request $request, CreateTaskHandler $handler): Response
    {
        $title = $request->request->get('title');
        $handler->handle($title);

        return $this->json(['message' => 'Task created successfully']);
    }

}
