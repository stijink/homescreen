<?php

namespace App\Controller;

use App\Component\Presence;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponse
     * @throws \App\ApiException
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->presenceComponent->load());
    }
}
