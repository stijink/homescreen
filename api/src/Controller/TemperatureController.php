<?php

namespace App\Controller;

use App\Component\Temperature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TemperatureController extends Controller
{
    private $temperatureComponent;

    /**
     * @param $temperatureComponent
     */
    public function __construct(Temperature $temperatureComponent)
    {
        $this->temperatureComponent = $temperatureComponent;
    }

    /**
     * @Route("/temperature", name="temperature")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->temperatureComponent->load());
    }
}
