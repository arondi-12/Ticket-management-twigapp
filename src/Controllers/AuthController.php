<?php
// src/Controllers/AuthController.php

namespace App\Controllers;

use App\Services\AuthService;
use App\Utils\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController
{
    private $twig;
    private $authService;

    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->authService = new AuthService();
    }

    public function showLogin()
    {
        if ($this->authService->isAuthenticated()) {
            return new RedirectResponse('/dashboard');
        }

        return new Response($this->twig->render('auth/login.twig', [
            'error' => Session::flash('error'),
            'success' => Session::flash('success')
        ]));
    }

    public function login()
    {
        $request = Request::createFromGlobals();
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $result = $this->authService->login($email, $password);

        if ($result['success']) {
            Session::flash('success', 'Login successful! Welcome back.');
            return new RedirectResponse('/dashboard');
        }

        Session::flash('error', $result['message']);
        return new RedirectResponse('/login');
    }

    public function showSignup()
    {
        if ($this->authService->isAuthenticated()) {
            return new RedirectResponse('/dashboard');
        }

        return new Response($this->twig->render('auth/signup.twig', [
            'error' => Session::flash('error'),
            'success' => Session::flash('success')
        ]));
    }

    public function signup()
    {
        $request = Request::createFromGlobals();
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $confirmPassword = $request->request->get('confirmPassword');

        // Validation
        if ($password !== $confirmPassword) {
            Session::flash('error', 'Passwords do not match.');
            return new RedirectResponse('/signup');
        }

        $result = $this->authService->signup($name, $email, $password);

        if ($result['success']) {
            Session::flash('success', 'Account created successfully! Welcome to TicketFlow.');
            return new RedirectResponse('/dashboard');
        }

        Session::flash('error', $result['message']);
        return new RedirectResponse('/signup');
    }

    public function logout()
    {
        $this->authService->logout();
        Session::flash('success', 'You have been logged out successfully.');
        return new RedirectResponse('/');
    }
}