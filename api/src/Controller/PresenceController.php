<?php

namespace App\Controller;

use App\Component\Presence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PresenceController extends Controller
{
    private $presenceComponent;

    /**
     * @param Presence $presenceComponent
     */
    public function __construct(Presence $presenceComponent)
    {
        $this->presenceComponent = $presenceComponent;
    }

    /**
     * @Route("/presence", name="presence")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->presenceComponent->load());
    }
}
