<?php

namespace App\Controller;

use App\Component\Temperature;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponse
     * @throws \App\ApiException
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->temperatureComponent->load());
    }
}
