<?php

namespace App\Controller;

use App\Component\Calendar\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    private $calendarComponent;

    /**
     * @param Calendar $calendarComponent
     */
    public function __construct(Calendar $calendarComponent)
    {
        $this->calendarComponent = $calendarComponent;
    }

    /**
     * @Route("/calendar", name="calendar", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->calendarComponent->load());
    }
}
