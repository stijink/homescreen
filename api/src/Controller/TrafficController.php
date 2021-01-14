<?php

namespace App\Controller;

use App\Component\Traffic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TrafficController extends AbstractController
{
    public function __construct(private Traffic $trafficComponent)
    {
    }

    /**
     * @Route("/traffic", name="traffic", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->trafficComponent->load());
    }
}
