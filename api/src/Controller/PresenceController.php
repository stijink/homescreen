<?php

namespace App\Controller;

use App\Component\Presence;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PresenceController extends AbstractController
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
     * @Route("/presence", name="presence", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->presenceComponent->load());
    }
}
