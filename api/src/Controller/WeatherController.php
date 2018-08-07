<?php

namespace App\Controller;

use App\Component\Weather;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends Controller
{
    private $weatherComponent;

    /**
     * @param $weatherComponent
     */
    public function __construct(Weather $weatherComponent)
    {
        $this->weatherComponent = $weatherComponent;
    }

    /**
     * @Route("/weather", name="weather")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->weatherComponent->load());
    }
}
