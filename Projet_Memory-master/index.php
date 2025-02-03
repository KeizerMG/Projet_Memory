<?php
session_start();
require_once __DIR__ . '/config/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_PATH', __DIR__);

$page = $_GET['page'] ?? 'home';

$loginPath = '/Projet_Memory/views/auth/login.php';
$registerPath = '/Projet_Memory/views/auth/register.php';
$gamePath = '/Projet_Memory/views/game.php';
$homePath = '/Projet_Memory/views/home.php';

// Vérifiez si l'utilisateur veut remplir la base de données
if (isset($_GET['action']) && $_GET['action'] === 'fill_database') {
    require_once __DIR__ . '/scripts/fixture.php';
    exit;
}

switch($page) {
    case 'login':
        header("Location: $loginPath");
        break;
    case 'register':
        header("Location: $registerPath");
        break;
    case 'game':
        header("Location: $gamePath");
        break;
    default:
        header("Location: $homePath");
}
exit;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-white mb-8">Memory Game</h1>
            <a href="/Projet_Memory/views/auth/login.php" 
               class="inline-block px-8 py-4 text-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all font-semibold">
                Jouer au jeu
            </a>
        </div>
        <div class="text-center">
            <a href="?action=fill_database" 
               class="inline-block px-8 py-4 text-xl bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-lg hover:from-green-600 hover:to-teal-700 transition-all font-semibold">
                Remplir la base de données
            </a>
        </div>
    </div>
</body>
</html>
