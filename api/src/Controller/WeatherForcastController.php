<?php

namespace App\Controller;

use App\ApiException;
use App\Component\WeatherForcast;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WeatherForcastController extends AbstractController
{
    public function __construct(private WeatherForcast $weatherForcastComponent)
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
    #[Route(path: '/weather-forcast', name: 'weather_forcast')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->weatherForcastComponent->load());
    }
}
