<?php

namespace App\Controller;

use App\ApiException;
use App\Component\Weather;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    public function __construct(private Weather $weatherComponent)
    {
    }

    /**
     *
     * @throws ApiException
     * @return JsonResponse
     */
    /**
     *
     * @throws ApiException
     * @return JsonResponse
     */
    #[Route(path: '/weather', name: 'weather')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->weatherComponent->load());
    }
}
