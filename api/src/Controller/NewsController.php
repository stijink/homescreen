<?php

namespace App\Controller;

use App\Component\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    public function __construct(private News $newsComponent)
    {
    }

    #[Route(path: '/news', name: 'news')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->newsComponent->load());
    }
}
