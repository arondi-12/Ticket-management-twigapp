<?php

namespace App\Controllers;

use App\Services\TicketService;
use App\Utils\Session;
use Symfony\Component\HttpFoundation\Response;

class DashboardController
{
    private $twig;
    private $ticketService;

    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->ticketService = new TicketService();
    }

    public function index()
    {
        $stats = $this->ticketService->getStats();
        $user = Session::get('user');

        return new Response($this->twig->render('dashboard/index.twig', [
            'stats' => $stats,
            'user' => $user,
            'success' => Session::flash('success')
        ]));
    }
}
