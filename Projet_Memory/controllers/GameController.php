<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data) {
        try {
            $stmt = $db->prepare("
                INSERT INTO scores (user_id, score, time_elapsed, difficulty, badge) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $success = $stmt->execute([
                $_SESSION['user_id'],
                $data['score'],
                $data['timeUsed'],
                $data['difficulty'],
                $data['badge']
            ]);
            
            echo json_encode(['success' => $success]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
