<?php

namespace App\Controller;

use App\Component\Petrol;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PetrolController extends AbstractController
{
    public function __construct(private Petrol $petrolComponent)
    {
    }

    /**
     * @Route("/petrol", name="petrol", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->petrolComponent->load());
    }
}
