<?php

namespace App\Controller;

use App\Component\OpeningHours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OpeningHoursController extends Controller
{
    private $openingHoursComponent;

    /**
     * @param $openingHoursComponent
     */
    public function __construct(OpeningHours $openingHoursComponent)
    {
        $this->openingHoursComponent = $openingHoursComponent;
    }

    /**
     * @Route("/opening-hours", name="opening-hours")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->openingHoursComponent->load());
    }
}
