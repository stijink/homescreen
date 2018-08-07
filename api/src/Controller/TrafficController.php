<?php

namespace App\Controller;

use App\Component\Traffic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TrafficController extends Controller
{
    private $trafficComponent;

    /**
     * @param $trafficComponent
     */
    public function __construct(Traffic $trafficComponent)
    {
        $this->trafficComponent = $trafficComponent;
    }

    /**
     * @Route("/traffic", name="traffic")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->trafficComponent->load());
    }
}
