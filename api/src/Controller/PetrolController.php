<?php

namespace App\Controller;

use App\ApiException;
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
     *
     * @throws ApiException
     * @return JsonResponse
     */
    /**
     *
     * @throws ApiException
     * @return JsonResponse
     */
    #[Route(path: '/petrol', name: 'petrol')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->petrolComponent->load());
    }
}
