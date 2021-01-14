<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route(path: '/status', name: 'status')]
    public function index(): Response
    {
        return new Response('ok');
    }
}
