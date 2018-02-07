<?php

namespace App\Controller;

use App\Component\Raspberries;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RaspberriesController extends Controller
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
     * @return JsonResponse
     * @throws \App\ApiComponentException
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->raspberriesComponent->load());
    }
}
