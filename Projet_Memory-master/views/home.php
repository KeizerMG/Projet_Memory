<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game - Accueil</title>
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

       
        <div class="max-w-4xl mx-auto bg-gray-800/50 rounded-xl p-8 backdrop-blur-xl border border-gray-700">
            <h2 class="text-3xl font-bold text-white mb-8 text-center">Meilleurs scores</h2>
            <?php
            require_once __DIR__ . '/../config/database.php';
            
            try {
                $query = "SELECT 
                            users.username,
                            scores.score,
                            scores.time_elapsed,
                            scores.difficulty,
                            scores.badge
                        FROM users
                        INNER JOIN scores ON users.id = scores.user_id
                        ORDER BY scores.score DESC, scores.time_elapsed ASC
                        LIMIT 10";

                $stmt = $db->query($query);
                if(!$stmt) {
                    throw new PDOException($db->errorInfo()[2]);
                }
                $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($scores)) {
                    echo '<p class="text-gray-400 text-center">Aucun score enregistré pour le moment.</p>';
                } else {
                    echo '<div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="border-b border-gray-700">
                                    <tr class="text-gray-300">
                                        <th class="px-6 py-3 text-left">#</th>
                                        <th class="px-6 py-3 text-left">Joueur</th>
                                        <th class="px-6 py-3 text-center">Score</th>
                                        <th class="px-6 py-3 text-center">Temps</th>
                                        <th class="px-6 py-3 text-center">Difficulté</th>
                                        <th class="px-6 py-3 text-center">Badge</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    
                    foreach ($scores as $index => $score) {
                        $minutes = floor($score['time_elapsed'] / 60);
                        $seconds = $score['time_elapsed'] % 60;
                        $time = sprintf("%02d:%02d", $minutes, $seconds);
                        
                        $badgeClass = match($score['badge']) {
                            'gold' => 'bg-yellow-500',
                            'silver' => 'bg-gray-400',
                            'bronze' => 'bg-amber-700',
                            default => 'bg-gray-600'
                        };
                        
                        $badge = $score['badge'] ? 
                            "<span class='inline-block px-3 py-1 rounded-full text-sm {$badgeClass} text-white'>" . 
                            ucfirst($score['badge']) . "</span>" : '-';

                        echo "<tr class='hover:bg-gray-700/30'>
                                <td class='px-6 py-4 text-gray-400'>" . ($index + 1) . "</td>
                                <td class='px-6 py-4 text-white'>" . htmlspecialchars($score['username']) . "</td>
                                <td class='px-6 py-4 text-center text-white'>{$score['score']} pts</td>
                                <td class='px-6 py-4 text-center text-gray-300'>{$time}</td>
                                <td class='px-6 py-4 text-center text-gray-300'>" . ucfirst($score['difficulty']) . "</td>
                                <td class='px-6 py-4 text-center'>{$badge}</td>
                            </tr>";
                    }
                    
                    echo '</tbody></table></div>';
                }
            } catch (PDOException $e) {
                error_log("Erreur SQL : " . $e->getMessage());
                echo '<div class="text-red-500 text-center">
                        Une erreur est survenue lors de la récupération des scores.<br>
                        Détails : ' . htmlspecialchars($e->getMessage()) . '
                      </div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
