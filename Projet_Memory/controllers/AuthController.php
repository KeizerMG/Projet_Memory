<?php
session_start();
require_once '../config/database.php';

$action = $_GET['action'] ?? '';

if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
        exit;
    }

    try {
        // Vérifier si l'email est déjà utilisé
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé']);
            exit;
        }

        // Insérer le nouvel utilisateur
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            echo json_encode(['success' => true, 'message' => 'Inscription réussie']);
        } else {
            error_log("Erreur lors de l'exécution de la requête d'insertion : " . implode(", ", $stmt->errorInfo()));
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription']);
        }
    } catch (PDOException $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        error_log($e->getTraceAsString());
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription : ' . $e->getMessage()]);
    }
} else if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Identifiants incorrects']);
        }
    } catch (PDOException $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        error_log($e->getTraceAsString());
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la connexion : ' . $e->getMessage()]);
    }
} else if ($action === 'logout') {
    session_destroy();
    echo json_encode(['success' => true]);
}
?>
