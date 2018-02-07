<?php

namespace App\Controller;

use App\Component\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponse
     * @throws \App\ApiComponentException
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->newsComponent->load());
    }
}
