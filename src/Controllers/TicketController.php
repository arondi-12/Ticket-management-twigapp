<?php

namespace App\Controllers;

use App\Services\TicketService;
use App\Utils\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TicketController
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
        $tickets = $this->ticketService->getAll();
        $user = Session::get('user');

        // Sort by date (newest first)
        usort($tickets, function($a, $b) {
            return strtotime($b['createdAt']) - strtotime($a['createdAt']);
        });

        return new Response($this->twig->render('tickets/index.twig', [
            'tickets' => $tickets,
            'user' => $user,
            'success' => Session::flash('success'),
            'error' => Session::flash('error')
        ]));
    }

    public function create()
    {
        $user = Session::get('user');

        return new Response($this->twig->render('tickets/form.twig', [
            'user' => $user,
            'isEdit' => false,
            'ticket' => null
        ]));
    }

    public function store()
    {
        $request = Request::createFromGlobals();
        $user = Session::get('user');

        $data = [
            'title' => $request->request->get('title'),
            'description' => $request->request->get('description'),
            'status' => $request->request->get('status'),
            'priority' => $request->request->get('priority'),
            'createdBy' => $user['email']
        ];

        // Validation
        if (empty($data['title'])) {
            Session::flash('error', 'Title is required.');
            return new RedirectResponse('/tickets/new');
        }

        $this->ticketService->create($data);
        Session::flash('success', 'Ticket created successfully!');
        return new RedirectResponse('/tickets');
    }

    public function edit($id)
    {
        $ticket = $this->ticketService->getById($id);
        $user = Session::get('user');

        if (!$ticket) {
            Session::flash('error', 'Ticket not found.');
            return new RedirectResponse('/tickets');
        }

        return new Response($this->twig->render('tickets/form.twig', [
            'user' => $user,
            'isEdit' => true,
            'ticket' => $ticket
        ]));
    }

    public function update($id)
    {
        $request = Request::createFromGlobals();

        $data = [
            'title' => $request->request->get('title'),
            'description' => $request->request->get('description'),
            'status' => $request->request->get('status'),
            'priority' => $request->request->get('priority')
        ];

        // Validation
        if (empty($data['title'])) {
            Session::flash('error', 'Title is required.');
            return new RedirectResponse('/tickets/edit/' . $id);
        }

        $ticket = $this->ticketService->update($id, $data);

        if ($ticket) {
            Session::flash('success', 'Ticket updated successfully!');
        } else {
            Session::flash('error', 'Ticket not found.');
        }

        return new RedirectResponse('/tickets');
    }

    public function delete($id)
    {
        $result = $this->ticketService->delete($id);

        if ($result) {
            Session::flash('success', 'Ticket deleted successfully!');
        } else {
            Session::flash('error', 'Ticket not found.');
        }

        return new RedirectResponse('/tickets');
    }
}