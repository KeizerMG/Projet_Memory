<?php
$host = 'localhost';
$dbname = 'memory_game';
$username = 'root';
$password = '';

// Créer la base de données
try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Base de données créée avec succès.\n";
} catch (PDOException $e) {
    die("Erreur lors de la création de la base de données: " . $e->getMessage());
}

// Importer le fichier SQL
try {
    $pdo->exec("USE $dbname");
    $sql = file_get_contents('database/memory_game.sql');
    $pdo->exec($sql);
    echo "Tables créées avec succès.\n";
} catch (PDOException $e) {
    die("Erreur lors de l'importation du fichier SQL: " . $e->getMessage());
}
?>
