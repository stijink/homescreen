<?php

namespace App\Controller;

use App\Component\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    private $newsComponent;

    /**
     * @param $newsComponent
     */
    public function __construct(News $newsComponent)
    {
        $this->newsComponent = $newsComponent;
    }

    /**
     * @Route("/news", name="news")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->newsComponent->load());
    }
}
