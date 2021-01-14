<?php

namespace App\Controller;

use App\Component\OpeningHours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OpeningHoursController extends AbstractController
{
    public function __construct(private OpeningHours $openingHoursComponent)
    {
    }

    #[Route(path: '/opening-hours', name: 'opening-hours')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->openingHoursComponent->load());
    }
}
