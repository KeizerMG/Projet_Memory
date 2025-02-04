<?php
session_start();
require_once __DIR__ . '/Projet_Memory/config/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_PATH', __DIR__);

// Error handling
set_exception_handler(function($e) {
    error_log("Exception: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    error_log($e->getTraceAsString());
    http_response_code(500);
    echo "An unexpected error occurred. Please try again later.";
    exit;
});

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== NULL) {
        error_log("Fatal error: " . $error['message'] . " in " . $error['file'] . " on line " . $error['line']);
        http_response_code(500);
        echo "An unexpected error occurred. Please try again later.";
        exit;
    }
});

$page = $_GET['page'] ?? 'home';

$loginPath = BASE_PATH . '/Projet_Memory/views/auth/login.php';
$registerPath = BASE_PATH . '/Projet_Memory/views/auth/register.php';
$gamePath = BASE_PATH . '/Projet_Memory/views/game.php';
$homePath = BASE_PATH . '/Projet_Memory/views/home.php';

if (isset($_GET['action']) && $_GET['action'] === 'fill_database') {
    require_once __DIR__ . '/Projet_Memory/scripts/fixture.php';
    exit;
}

try {
    switch($page) {
        case 'login':
            if (file_exists($loginPath)) {
                require $loginPath;
            } else {
                throw new Exception("Page not found: $loginPath");
            }
            break;
        case 'register':
            if (file_exists($registerPath)) {
                require $registerPath;
            } else {
                throw new Exception("Page not found: $registerPath");
            }
            break;
        case 'game':
            if (file_exists($gamePath)) {
                require $gamePath;
            } else {
                throw new Exception("Page not found: $gamePath");
            }
            break;
        default:
            if (file_exists($homePath)) {
                require $homePath;
            } else {
                throw new Exception("Page not found: $homePath");
            }
    }
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    http_response_code(404);
    echo "Page not found.";
    exit;
}
exit;
?>
