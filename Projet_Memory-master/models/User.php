<?php
require_once __DIR__ . '/../config/database.php';

function getTopScores($limit = 10) {
    global $db;
    
    try {
        $query = "SELECT 
                    users.username,
                    scores.score,
                    scores.time_elapsed,
                    scores.difficulty,
                    scores.badge,
                    scores.created_at
                FROM scores 
                JOIN users ON scores.user_id = users.id 
                ORDER BY scores.score DESC, scores.time_elapsed ASC
                LIMIT ?";
                
        $stmt = $db->prepare($query);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des scores : " . $e->getMessage());
        return [];
    }
}

function saveScore($userId, $score, $timeElapsed, $difficulty = 'normal') {
    global $db;
    
    try {
        $stmt = $db->prepare("INSERT INTO scores (user_id, score, time_elapsed, difficulty) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $score, $timeElapsed, $difficulty]);
    } catch (PDOException $e) {
        error_log("Erreur lors de la sauvegarde du score : " . $e->getMessage());
        return false;
    }
}
