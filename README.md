# ticket-app-twig

ticket-app-twig/
├── src/
│   ├── Controllers/
│   │   └── DashboardController.php
│   └── Services/
│       └── (optional backend logic)
├── templates/
│   ├── base.html.twig        
│   ├── pages/
│   │   └── dashboard.html.twig  
│   └── components/
│       ├── header.html.twig     
│       ├── footer.html.twig
│       └── stat-card.html.twig
├── public/
│   ├── css/
│   ├── js/
│   └── images/
└── index.php


ticket-app-twig/
├── public/                     
│   ├── css/
│   ├── js/
│   └── images/
│
├── src/                        
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── TicketsController.php
│   │   └── AuthController.php
│   └── Services/
│       ├── AuthService.php
│       └── TicketService.php
│
├── templates/                  
│   ├── base.html.twig          
│   ├── components/             
│   │   ├── header.html.twig
│   │   ├── footer.html.twig
│   │   ├── ticket-card.html.twig
│   │   └── toast.html.twig
│   ├── pages/                  
│   │   ├── login.html.twig
│   │   ├── signup.html.twig
│   │   ├── dashboard.html.twig
│   │   ├── tickets.html.twig
│   │   └── landing.html.twig
│   └── partials/               
│       └── modal.html.twig
│
├── vendor/                     
├── composer.json
└── index.php                   
