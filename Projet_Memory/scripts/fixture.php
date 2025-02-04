<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Faker\Factory;

$faker = Factory::create();


$db->exec('SET FOREIGN_KEY_CHECKS = 0');
$db->exec('TRUNCATE TABLE scores');
$db->exec('TRUNCATE TABLE users');
$db->exec('SET FOREIGN_KEY_CHECKS = 1');


function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}


$users = [
    ['username' => 'admin', 'email' => 'admin@example.com', 'password' => hashPassword('1234')],
    ['username' => 'user', 'email' => 'user@example.com', 'password' => hashPassword('user')]
];

foreach ($users as $user) {
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$user['username'], $user['email'], $user['password']]);
}

for ($i = 0; $i < 10; $i++) {
    $username = $faker->userName;
    $email = $faker->email;
    $password = hashPassword('password'); 

    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);
}


$userIds = $db->query("SELECT id FROM users")->fetchAll(PDO::FETCH_COLUMN);


foreach ($userIds as $userId) {
    for ($j = 0; $j < 5; $j++) {
        $score = $faker->numberBetween(0, 1000);
        $difficulty = $faker->randomElement(['easy', 'medium', 'hard']);
        
       
        switch ($difficulty) {
            case 'easy':
                $timeElapsed = $faker->numberBetween(0, 300); 
                break;
            case 'medium':
                $timeElapsed = $faker->numberBetween(0, 270);
                break;
            case 'hard':
                $timeElapsed = $faker->numberBetween(0, 240);
                break;
        }

     
        if ($timeElapsed <= 0.5 * ($difficulty === 'easy' ? 300 : ($difficulty === 'medium' ? 270 : 240))) {
            $badge = 'gold';
        } elseif ($timeElapsed <= 0.75 * ($difficulty === 'easy' ? 300 : ($difficulty === 'medium' ? 270 : 240))) {
            $badge = 'silver';
        } else {
            $badge = 'bronze';
        }

        $stmt = $db->prepare("INSERT INTO scores (user_id, score, time_elapsed, difficulty, badge) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $score, $timeElapsed, $difficulty, $badge]);
    }
}

echo "Base de données remplie avec succès.\n";
?>
