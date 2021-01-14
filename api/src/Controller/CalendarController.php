<?php

namespace App\Controller;

use App\Component\Calendar\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    public function __construct(private Calendar $calendarComponent)
    {
    }

    #[Route(path: '/calendar', name: 'calendar')]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->calendarComponent->load());
    }
}
