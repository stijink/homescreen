<?php

namespace App\Controller;

use App\Component\Raspberries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RaspberriesController extends AbstractController
{
    public function __construct(private Raspberries $raspberriesComponent)
    {
    }

    /**
     * @Route("/raspberries", name="raspberries", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->raspberriesComponent->load());
    }
}
