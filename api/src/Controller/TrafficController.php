<?php

namespace App\Controller;

use App\Component\Traffic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponse
     * @throws \App\ApiException
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->trafficComponent->load());
    }
}
