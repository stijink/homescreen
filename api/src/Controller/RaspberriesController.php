<?php

namespace App\Controller;

use App\Component\Raspberries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RaspberriesController extends AbstractController
{
    private $raspberriesComponent;

    /**
     * @param $raspberriesComponent
     */
    public function __construct(Raspberries $raspberriesComponent)
    {
        $this->raspberriesComponent = $raspberriesComponent;
    }

    /**
     * @Route("/raspberries", name="raspberries")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->raspberriesComponent->load());
    }
}
