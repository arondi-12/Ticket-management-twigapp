<!-- 

// require_once __DIR__ . '/../vendor/autoload.php';

// use App\Utils\Router;
// use App\Utils\Session;
// use App\Controllers\AuthController;
// use App\Controllers\DashboardController;
// use App\Controllers\TicketController;

// // Start session
// Session::start();

// // Load configuration
// $config = require __DIR__ . '/../config/config.php';

// // Initialize Twig
// $loader = new \Twig\Loader\FilesystemLoader($config['paths']['templates']);
// $twig = new \Twig\Environment($loader, [
//     'cache' => $config['app']['debug'] ? false : $config['paths']['cache'],
//     'debug' => $config['app']['debug']
// ]);

// // Add global variables to Twig
// $twig->addGlobal('app_name', $config['app']['name']);
// $twig->addGlobal('current_user', Session::get('user'));
// $twig->addGlobal('is_authenticated', Session::has('user'));

// // Initialize router
// $router = new Router($twig);

// // Define routes
// // Landing page
// $router->get('/', function() use ($twig) {
//     echo $twig->render('landing.twig');
// });

// // Auth routes
// $router->get('/login', [AuthController::class, 'showLogin']);
// $router->post('/login', [AuthController::class, 'login']);
// $router->get('/signup', [AuthController::class, 'showSignup']);
// $router->get('/register', [AuthController::class, 'showSignup']); // Alias
// $router->post('/signup', [AuthController::class, 'signup']);
// $router->get('/logout', [AuthController::class, 'logout']);

// // Dashboard routes (protected)
// $router->get('/dashboard', [DashboardController::class, 'index'], true);

// // Ticket routes (protected)
// $router->get('/tickets', [TicketController::class, 'index'], true);
// $router->get('/tickets/new', [TicketController::class, 'create'], true);
// $router->post('/tickets', [TicketController::class, 'store'], true);
// $router->get('/tickets/edit/{id}', [TicketController::class, 'edit'], true);
// $router->post('/tickets/update/{id}', [TicketController::class, 'update'], true);
// $router->post('/tickets/delete/{id}', [TicketController::class, 'delete'], true);

// // Run the router
// $router->run(); -->

<?php
// public/index.php - DEBUG VERSION

echo "<h1>Testing Setup</h1>";

// Test 1: Composer autoload
echo "<h2>1. Composer Autoload</h2>";
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "✅ Autoload found and loaded<br>";
} else {
    echo "❌ Autoload NOT found. Run 'composer install'<br>";
    exit;
}

// Test 2: Config file
echo "<h2>2. Config File</h2>";
if (file_exists(__DIR__ . '/../config/config.php')) {
    $config = require __DIR__ . '/../config/config.php';
    echo "✅ Config loaded<br>";
    echo "App Name: " . $config['app']['name'] . "<br>";
} else {
    echo "❌ Config file NOT found<br>";
    exit;
}

// Test 3: Templates directory
echo "<h2>3. Templates Directory</h2>";
if (is_dir($config['paths']['templates'])) {
    echo "✅ Templates directory exists<br>";
    $files = scandir($config['paths']['templates']);
    echo "Files: " . implode(', ', array_diff($files, ['.', '..'])) . "<br>";
} else {
    echo "❌ Templates directory NOT found<br>";
}

// Test 4: Twig
echo "<h2>4. Twig</h2>";
try {
    $loader = new \Twig\Loader\FilesystemLoader($config['paths']['templates']);
    $twig = new \Twig\Environment($loader, ['cache' => false, 'debug' => true]);
    echo "✅ Twig initialized successfully<br>";
} catch (Exception $e) {
    echo "❌ Twig error: " . $e->getMessage() . "<br>";
}

echo "<h2>5. Classes</h2>";
echo "Router exists: " . (class_exists('App\Utils\Router') ? "✅" : "❌") . "<br>";
echo "Session exists: " . (class_exists('App\Utils\Session') ? "✅" : "❌") . "<br>";
echo "AuthController exists: " . (class_exists('App\Controllers\AuthController') ? "✅" : "❌") . "<br>";

echo "<h2>✅ All tests passed! Now replace with the real index.php</h2>";