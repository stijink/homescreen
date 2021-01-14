<?php

namespace App\Controller;

use App\Component\Temperature;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TemperatureController extends AbstractController
{
    public function __construct(private Temperature $temperatureComponent)
    {
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
