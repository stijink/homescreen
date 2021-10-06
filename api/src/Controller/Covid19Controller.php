<?php

namespace App\Controller;

use App\Component\Covid19;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class Covid19Controller extends AbstractController
{
    public function __construct(private Covid19 $covid19Component)
    {
    }

    #[Route(path: '/covid19', name: 'covid19')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->covid19Component->load());
    }
}
