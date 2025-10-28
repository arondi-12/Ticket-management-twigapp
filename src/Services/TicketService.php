<?php

namespace App\Services;

class TicketService
{
    private const TICKETS_FILE = __DIR__ . '/../../data/tickets.json';

    public function __construct()
    {
        $this->initializeTickets();
    }

    private function initializeTickets()
    {
        if (!file_exists(dirname(self::TICKETS_FILE))) {
            mkdir(dirname(self::TICKETS_FILE), 0755, true);
        }

        if (!file_exists(self::TICKETS_FILE)) {
            $demoTickets = [
                [
                    'id' => '1',
                    'title' => 'Login page not loading',
                    'description' => 'Users are reporting issues accessing the login page. It shows a blank screen.',
                    'status' => 'open',
                    'priority' => 'high',
                    'createdAt' => '2024-10-20T10:00:00Z',
                    'updatedAt' => '2024-10-20T10:00:00Z',
                    'createdBy' => 'user@ticketflow.com'
                ],
                [
                    'id' => '2',
                    'title' => 'Update dashboard analytics',
                    'description' => 'Need to add new charts for better data visualization on the dashboard.',
                    'status' => 'in_progress',
                    'priority' => 'medium',
                    'createdAt' => '2024-10-22T14:30:00Z',
                    'updatedAt' => '2024-10-24T09:15:00Z',
                    'createdBy' => 'admin@ticketflow.com'
                ],
                [
                    'id' => '3',
                    'title' => 'Fix email notification bug',
                    'description' => 'Email notifications are not being sent when tickets are updated.',
                    'status' => 'closed',
                    'priority' => 'high',
                    'createdAt' => '2024-10-18T08:00:00Z',
                    'updatedAt' => '2024-10-23T16:45:00Z',
                    'createdBy' => 'user@ticketflow.com'
                ],
                [
                    'id' => '4',
                    'title' => 'Add dark mode support',
                    'description' => 'Implement dark mode theme for better user experience.',
                    'status' => 'open',
                    'priority' => 'low',
                    'createdAt' => '2024-10-25T11:20:00Z',
                    'updatedAt' => '2024-10-25T11:20:00Z',
                    'createdBy' => 'admin@ticketflow.com'
                ]
            ];
            file_put_contents(self::TICKETS_FILE, json_encode($demoTickets, JSON_PRETTY_PRINT));
        }
    }

    private function getTickets()
    {
        return json_decode(file_get_contents(self::TICKETS_FILE), true);
    }

    private function saveTickets($tickets)
    {
        file_put_contents(self::TICKETS_FILE, json_encode($tickets, JSON_PRETTY_PRINT));
    }

    public function getAll()
    {
        return $this->getTickets();
    }

    public function getById($id)
    {
        $tickets = $this->getTickets();
        foreach ($tickets as $ticket) {
            if ($ticket['id'] === $id) {
                return $ticket;
            }
        }
        return null;
    }

    public function create($data)
    {
        $tickets = $this->getTickets();
        
        $newTicket = [
            'id' => (string)time(),
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'status' => $data['status'] ?? 'open',
            'priority' => $data['priority'] ?? 'medium',
            'createdAt' => date('c'),
            'updatedAt' => date('c'),
            'createdBy' => $data['createdBy'] ?? 'unknown'
        ];
        
        $tickets[] = $newTicket;
        $this->saveTickets($tickets);
        
        return $newTicket;
    }

    public function update($id, $data)
    {
        $tickets = $this->getTickets();
        
        foreach ($tickets as &$ticket) {
            if ($ticket['id'] === $id) {
                $ticket['title'] = $data['title'];
                $ticket['description'] = $data['description'] ?? '';
                $ticket['status'] = $data['status'];
                $ticket['priority'] = $data['priority'] ?? $ticket['priority'];
                $ticket['updatedAt'] = date('c');
                
                $this->saveTickets($tickets);
                return $ticket;
            }
        }
        
        return null;
    }

    public function delete($id)
    {
        $tickets = $this->getTickets();
        $filtered = array_filter($tickets, fn($t) => $t['id'] !== $id);
        
        if (count($filtered) < count($tickets)) {
            $this->saveTickets(array_values($filtered));
            return true;
        }
        
        return false;
    }

    public function getStats()
    {
        $tickets = $this->getTickets();
        
        return [
            'total' => count($tickets),
            'open' => count(array_filter($tickets, fn($t) => $t['status'] === 'open')),
            'inProgress' => count(array_filter($tickets, fn($t) => $t['status'] === 'in_progress')),
            'closed' => count(array_filter($tickets, fn($t) => $t['status'] === 'closed')),
            'highPriority' => count(array_filter($tickets, fn($t) => $t['priority'] === 'high')),
            'mediumPriority' => count(array_filter($tickets, fn($t) => $t['priority'] === 'medium')),
            'lowPriority' => count(array_filter($tickets, fn($t) => $t['priority'] === 'low'))
        ];
    }
}