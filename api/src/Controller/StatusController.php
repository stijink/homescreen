<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
{
    /**
     * @Route("/status", name="status")
     * @return Response
     */
    public function index(): Response
    {
        return new Response('ok');
    }
}
