<?php

namespace App\Controller;

use App\Component\Petrol;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PetrolController extends Controller
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
     * @return JsonResponse
     * @throws \App\ApiComponentException
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->petrolComponent->load());
    }
}
