<?php

namespace App\Controller;

use App\Component\WeatherForcast;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WeatherForcastController extends AbstractController
{
    private $weatherForcastComponent;

    /**
     * @param $weatherForcastComponent
     */
    public function __construct(WeatherForcast $weatherForcastComponent)
    {
        $this->weatherForcastComponent = $weatherForcastComponent;
    }

    /**
     * @Route("/weather-forcast", name="weather_forcast")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->weatherForcastComponent->load());
    }
}
