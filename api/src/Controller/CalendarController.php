<?php

namespace App\Controller;

use App\Component\Calendar\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CalendarController extends Controller
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
     * @Route("/calendar", name="calendar")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->calendarComponent->load());
    }
}
