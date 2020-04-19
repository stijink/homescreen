<?php

namespace App\Controller;

use App\Component\Temperature;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TemperatureController extends AbstractController
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
     * @Route("/temperature", name="temperature", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->temperatureComponent->load());
    }
}
