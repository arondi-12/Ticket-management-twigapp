<?php
// src/Services/AuthService.php

namespace App\Services;

use App\Utils\Session;

class AuthService
{
    private const USERS_FILE = __DIR__ . '/../../data/users.json';

    public function __construct()
    {
        $this->initializeUsers();
    }

    private function initializeUsers()
    {
        if (!file_exists(dirname(self::USERS_FILE))) {
            mkdir(dirname(self::USERS_FILE), 0755, true);
        }

        if (!file_exists(self::USERS_FILE)) {
            $demoUsers = [
                [
                    'id' => '1',
                    'email' => 'admin@ticketflow.com',
                    'password' => password_hash('admin123', PASSWORD_DEFAULT),
                    'name' => 'Admin User',
                    'role' => 'admin'
                ],
                [
                    'id' => '2',
                    'email' => 'user@ticketflow.com',
                    'password' => password_hash('user123', PASSWORD_DEFAULT),
                    'name' => 'Demo User',
                    'role' => 'user'
                ]
            ];
            file_put_contents(self::USERS_FILE, json_encode($demoUsers, JSON_PRETTY_PRINT));
        }
    }

    private function getUsers()
    {
        return json_decode(file_get_contents(self::USERS_FILE), true);
    }

    private function saveUsers($users)
    {
        file_put_contents(self::USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
    }

    public function login($email, $password)
    {
        $users = $this->getUsers();
        
        foreach ($users as $user) {
            if ($user['email'] === $email && password_verify($password, $user['password'])) {
                $sessionData = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'role' => $user['role']
                ];
                Session::set('user', $sessionData);
                return ['success' => true, 'user' => $sessionData];
            }
        }
        
        return ['success' => false, 'message' => 'Invalid email or password. Please try again.'];
    }

    public function signup($name, $email, $password)
    {
        $users = $this->getUsers();
        
        // Check if email exists
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return ['success' => false, 'message' => 'This email is already registered. Please login instead.'];
            }
        }
        
        // Create new user
        $newUser = [
            'id' => (string)time(),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'name' => $name,
            'role' => 'user'
        ];
        
        $users[] = $newUser;
        $this->saveUsers($users);
        
        // Auto login
        $sessionData = [
            'id' => $newUser['id'],
            'email' => $newUser['email'],
            'name' => $newUser['name'],
            'role' => $newUser['role']
        ];
        Session::set('user', $sessionData);
        
        return ['success' => true, 'user' => $sessionData];
    }

    public function logout()
    {
        Session::delete('user');
        Session::destroy();
    }

    public function isAuthenticated()
    {
        return Session::has('user');
    }

    public function getCurrentUser()
    {
        return Session::get('user');
    }
}
