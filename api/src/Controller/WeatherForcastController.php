<?php

namespace App\Controller;

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
     * @Route("/weather-forcast", name="weather_forcast", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->weatherForcastComponent->load());
    }
}
