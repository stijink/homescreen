<?php

namespace App\Controller;

use App\Component\Petrol;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PetrolController extends AbstractController
{
    private $petrolComponent;

    /**
     * @param Petrol $petrolComponent
     */
    public function __construct(Petrol $petrolComponent)
    {
        $this->petrolComponent = $petrolComponent;
    }

    /**
     * @Route("/petrol", name="petrol")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->petrolComponent->load());
    }
}
