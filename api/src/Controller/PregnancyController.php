<?php

namespace App\Controller;

use App\Component\Pregnancy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PregnancyController extends AbstractController
{
    private $pregnancyComponent;

    /**
     * @param Pregnancy $pregnancyComponent
     */
    public function __construct(Pregnancy $pregnancyComponent)
    {
        $this->pregnancyComponent = $pregnancyComponent;
    }

    /**
     * @Route("/pregnancy", name="pregnancy")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->pregnancyComponent->load());
    }
}
