<?php

namespace App\Controller;

use App\Component\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends Controller
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
