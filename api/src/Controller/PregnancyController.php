<?php

namespace App\Controller;

use App\Component\Pregnancy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PregnancyController extends AbstractController
{
    public function __construct(private Pregnancy $pregnancyComponent)
    {
    }

    /**
     * @Route("/pregnancy", name="pregnancy", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->pregnancyComponent->load());
    }
}
