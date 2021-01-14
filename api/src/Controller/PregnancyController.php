<?php

namespace App\Controller;

use App\ApiException;
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
     *
     * @throws ApiException
     * @return JsonResponse
     */
    /**
     *
     * @throws ApiException
     * @return JsonResponse
     */
    #[Route(path: '/pregnancy', name: 'pregnancy')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->pregnancyComponent->load());
    }
}
