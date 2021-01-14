<?php

namespace App\Controller;

use App\ApiException;
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
     *
     * @throws ApiException
     * @return JsonResponse
     */
    /**
     *
     * @throws ApiException
     * @return JsonResponse
     */
    #[Route(path: '/temperature', name: 'temperature')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->temperatureComponent->load());
    }
}
