<?php

namespace App\Controller;

use App\ApiException;
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
     *
     * @throws ApiException
     * @return JsonResponse
     */
    /**
     *
     * @throws ApiException
     * @return JsonResponse
     */
    #[Route(path: '/traffic', name: 'traffic')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->trafficComponent->load());
    }
}
