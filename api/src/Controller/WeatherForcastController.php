<?php

namespace App\Controller;

use App\Component\WeatherForcast;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class WeatherForcastController extends Controller
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
