<?php

namespace App\Controller;

use App\ApiException;
use App\Component\Presence;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PresenceController extends AbstractController
{
    public function __construct(private Presence $presenceComponent)
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
    #[Route(path: '/presence', name: 'presence')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->presenceComponent->load());
    }
}
