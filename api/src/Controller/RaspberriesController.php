<?php

namespace App\Controller;

use App\ApiException;
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
     *
     * @throws ApiException
     * @return JsonResponse
     */
    /**
     *
     * @throws ApiException
     * @return JsonResponse
     */
    #[Route(path: '/raspberries', name: 'raspberries')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->raspberriesComponent->load());
    }
}
