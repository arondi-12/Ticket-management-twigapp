# ticket-app-twig

ticket-app-twig/
├── src/
│   ├── Controllers/
│   │   └── DashboardController.php
│   └── Services/
│       └── (optional backend logic)
├── templates/
│   ├── base.html.twig        ← your global layout (like App.jsx)
│   ├── pages/
│   │   └── dashboard.html.twig  ← 🟢 your Dashboard page (this file)
│   └── components/
│       ├── header.html.twig     ← optional reusable component
│       ├── footer.html.twig
│       └── stat-card.html.twig
├── public/
│   ├── css/
│   ├── js/
│   └── images/
└── index.php


ticket-app-twig/
├── public/                     # for CSS, JS, images (like React public/)
│   ├── css/
│   ├── js/
│   └── images/
│
├── src/                        # PHP business logic
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── TicketsController.php
│   │   └── AuthController.php
│   └── Services/
│       ├── AuthService.php
│       └── TicketService.php
│
├── templates/                  # Twig templates (HTML)
│   ├── base.html.twig          # main layout (like App.jsx)
│   ├── components/             # reusable UI pieces
│   │   ├── header.html.twig
│   │   ├── footer.html.twig
│   │   ├── ticket-card.html.twig
│   │   └── toast.html.twig
│   ├── pages/                  # page-level templates (like React routes)
│   │   ├── login.html.twig
│   │   ├── signup.html.twig
│   │   ├── dashboard.html.twig
│   │   ├── tickets.html.twig
│   │   └── landing.html.twig
│   └── partials/               # optional sub-layouts or modals
│       └── modal.html.twig
│
├── vendor/                     # (composer)
├── composer.json
└── index.php                   # entry point / router
