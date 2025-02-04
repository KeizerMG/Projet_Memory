<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: /Projet_Memory/index.php?page=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game - Jeu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .memory-card {
            perspective: 1000px;
            transform-style: preserve-3d;
            transition: transform 0.6s cubic-bezier(0.4, 0.0, 0.2, 1);
            cursor: pointer;
        }

        .memory-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .memory-card.flipped {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.6s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        .card-front {
            transform: rotateY(180deg);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .card-back {
            background: linear-gradient(135deg, #6366f1 0%, #2563eb 100%);
            border: 2px solid #818cf8;
            transform: rotateY(0);
            position: relative;
            overflow: hidden;
        }

        .card-back::before {
            content: '?';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2.5rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: bold;
        }

        .memory-card img {
            width: 80%;
            height: 80%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .memory-card.flipped img {
            transform: scale(1.1);
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #374151;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            transition: width 1s linear, background-color 0.3s;
        }

       
        .progress-green { background-color: #10B981; }
        .progress-yellow { background-color: #F59E0B; }
        .progress-red { background-color: #EF4444; }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .badge-bronze { background: #92400E; }
        .badge-silver { background: #94A3B8; }
        .badge-gold { background: #F59E0B; }

        .victory-modal, .defeat-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 50;
        }

        .modal-content {
            animation: modalSlideIn 0.5s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .card {
            width: 100px;
            height: 150px;
            background-image: url('/Projet_Memory/Projet_Memory/assets/card-back.png');
            background-size: cover;
            border-radius: 8px;
            cursor: pointer;
        }
        .card.flipped {
            background-image: none;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen">
 
    <nav class="bg-gray-800/80 backdrop-blur-sm px-4 py-3 sticky top-0 z-50 border-b border-gray-700">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button onclick="logout()" 
                    class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3zm7 8.414l3.293-3.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 1 1 1.414-1.414L10 11.414z"/>
                    </svg>
                    Déconnexion
                </button>
            
                <select id="difficulty" class="bg-gray-700 text-white rounded-lg px-3 py-2" onchange="setDifficulty()">
                    <option value="easy">Facile</option>
                    <option value="medium">Moyen</option>
                    <option value="hard">Difficile</option>
                </select>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-white text-xl">Score: <span id="score" class="font-bold">0</span></span>
                <span class="text-white text-xl">Temps: <span id="timer" class="font-bold">00:00</span></span>
                <div class="w-48">
                    <div class="progress-bar">
                        <div id="progressBar" class="progress-bar-fill progress-green" style="width: 100%"></div>
                    </div>
                </div>
                <span class="text-white text-xl">Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</span>
            </div>
        </div>
    </nav>

    <div class="p-8">
        <div class="max-w-7xl mx-auto">
            <div id="gameGrid" class="grid gap-4 max-w-6xl mx-auto p-8 bg-gray-800/30 rounded-2xl backdrop-blur-sm">
             
            </div>
        </div>
    </div>

    
    <div id="debug-info" class="fixed bottom-4 right-4 bg-black/80 text-white p-4 rounded-lg" style="display:none;">
        <h3>Informations de débogage:</h3>
        <p>Document Root: <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
        <p>Chemin des images: /Projet_Memory/assets/images/</p>
    </div>

    
    <div id="debug" class="fixed bottom-4 right-4 bg-gray-800 p-4 rounded-lg text-white text-sm" style="display: none;">
        <h3 class="font-bold mb-2">Images manquantes :</h3>
        <ul id="missingImages"></ul>
    </div>

    <div id="victoryModal" class="victory-modal flex items-center justify-center">
        <div class="modal-content bg-gray-800 p-8 rounded-2xl max-w-md w-full mx-4">
            <div class="text-center">
                <div class="w-20 h-20 bg-green-500 rounded-full mx-auto flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Félicitations !</h2>
                <p id="victoryMessage" class="text-gray-300 mb-6"></p>
                <div id="badgeDisplay" class="mb-6"></div>
                <div class="flex flex-col gap-3">
                    <button onclick="resetGame()" class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        Rejouer
                    </button>
                    <a href="/Projet_Memory/views/home.php" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-center">
                        Voir les scores
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div id="defeatModal" class="defeat-modal flex items-center justify-center">
        <div class="modal-content bg-gray-800 p-8 rounded-2xl max-w-md w-full mx-4">
            <div class="text-center">
                <div class="w-20 h-20 bg-red-500 rounded-full mx-auto flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Temps écoulé !</h2>
                <p class="text-gray-300 mb-6">Vous n'avez pas réussi à terminer le niveau à temps.</p>
                <div class="flex flex-col gap-3">
                    <button onclick="resetGame()" class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                        Réessayer
                    </button>
                    <a href="/Projet_Memory/views/home.php" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-center">
                        Voir les scores
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
    
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', function() {
                const debug = document.getElementById('debug');
                const list = document.getElementById('missingImages');
                debug.style.display = 'block';
                list.innerHTML += `<li>${this.src}</li>`;
            });
        });

    
        function logout() {
            fetch('/Projet_Memory/controllers/AuthController.php?action=logout', {
                method: 'POST'
            }).then(() => {
                window.location.href = '/Projet_Memory/index.php?page=login';
            });
        }

        
        const DIFFICULTY_SETTINGS = {
            easy: { rows: 4, cols: 5, time: 300 }, 
            medium: { rows: 4, cols: 6, time: 270 }, 
            hard: { rows: 4, cols: 7, time: 240 }  
        };

        let currentDifficulty = 'easy';
        let timeLeft;
        let totalTime;

        function setDifficulty() {
            currentDifficulty = document.getElementById('difficulty').value;
            resetGame();
        }

        function resetGame() {
           
            const settings = DIFFICULTY_SETTINGS[currentDifficulty];
            timeLeft = settings.time;
            totalTime = settings.time;
            stopTimer();
            timeStarted = false;
            score = 0;
            matches = 0;
            document.getElementById('score').textContent = '0';
            document.getElementById('timer').textContent = formatTime(timeLeft);
            document.getElementById('progressBar').style.width = '100%';
            document.getElementById('progressBar').className = 'progress-bar-fill progress-green';
            
          
            document.getElementById('victoryModal').style.display = 'none';
            document.getElementById('defeatModal').style.display = 'none';

          
            initializeGame();

            hasFlippedCard = false;
            lockBoard = false;
            firstCard = null;
            secondCard = null;
        }

        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
        }

        function updateProgressBar() {
            const percentage = (timeLeft / totalTime) * 100;
            const progressBar = document.getElementById('progressBar');
            
            progressBar.style.width = `${percentage}%`;
            
           
            if (percentage > 50) {
                progressBar.className = 'progress-bar-fill progress-green';
            } else if (percentage > 10) {
                progressBar.className = 'progress-bar-fill progress-yellow';
            } else {
                progressBar.className = 'progress-bar-fill progress-red';
            }
        }

        let timeStarted = false;
        let seconds = 0;
        let timerInterval;

        function startTimer() {
            if (!timeStarted) {
                timeStarted = true;
                timerInterval = setInterval(updateTimer, 1000);
            }
        }

        function updateTimer() {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('timer').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            updateProgressBar();

            if (timeLeft <= 0) {
                stopTimer();
                showDefeatAlert();
            }
        }

        function stopTimer() {
            clearInterval(timerInterval);
        }

        function calculateBadge(timeUsed) {
            const timePercentage = (timeUsed / totalTime) * 100;
            if (timePercentage < 50) return 'gold';
            if (timePercentage < 60) return 'silver';
            if (timePercentage < 80) return 'bronze';
            return null;
        }

   
        const cards = document.querySelectorAll('.memory-card');
        cards.forEach(card => {
            card.addEventListener('click', () => {
                startTimer(); 
                flipCard.call(card);
            });
        });

        let hasFlippedCard = false;
        let lockBoard = false;
        let firstCard, secondCard;
        let score = 0;
        let matches = 0;

        function flipCard() {
            if (lockBoard) return;
            if (this === firstCard) return;

            this.classList.add('flipped');

            if (!hasFlippedCard) {
                hasFlippedCard = true;
                firstCard = this;
                return;
            }

            secondCard = this;
            checkForMatch();
        }

        function checkForMatch() {
            let isMatch = firstCard.dataset.framework === secondCard.dataset.framework;

            if (isMatch) {
                matches++;
                score += 10;
                document.getElementById('score').textContent = score;
                disableCards();

             
                const settings = DIFFICULTY_SETTINGS[currentDifficulty];
                const totalPairs = (settings.rows * settings.cols) / 2;
                
                if (matches === totalPairs) {
                    stopTimer();
                    const timeUsed = totalTime - timeLeft;
                    showVictoryAlert(score, timeUsed);
                }
            } else {
                unflipCards();
            }
        }

        function showVictoryAlert(score, timeUsed) {
            const minutes = Math.floor(timeUsed / 60);
            const seconds = timeUsed % 60;
            const timeString = minutes > 0 ? 
                `${minutes} minute${minutes > 1 ? 's' : ''} et ${seconds} seconde${seconds > 1 ? 's' : ''}` : 
                `${seconds} seconde${seconds > 1 ? 's' : ''}`;
            
            const badge = calculateBadge(timeUsed);
            const badgeText = badge ? `\nVous avez gagné un badge ${badge} !` : '';

            Swal.fire({
                title: 'Félicitations !',
                text: `Vous avez terminé le niveau ${currentDifficulty} en ${timeString} avec un score de ${score} points! ${badgeText}`,
                icon: 'success',
                confirmButtonText: 'Rejouer',
                showCancelButton: true,
                cancelButtonText: 'Voir les scores',
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#3B82F6'
            }).then((result) => {
                if (result.isConfirmed) {
                    resetGame();
                } else {
                    window.location.href = '/Projet_Memory/views/home.php';
                }
            });

        
            saveScore(score, timeUsed, currentDifficulty, badge);
        }

        function showDefeatAlert() {
            Swal.fire({
                title: 'Temps écoulé !',
                text: 'Vous n\'avez pas réussi à terminer le niveau à temps.',
                icon: 'error',
                confirmButtonText: 'Réessayer',
                showCancelButton: true,
                cancelButtonText: 'Voir les scores',
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#3B82F6'
            }).then((result) => {
                if (result.isConfirmed) {
                    resetGame();
                } else {
                    window.location.href = '/Projet_Memory/views/home.php';
                }
            });
        }

        async function saveScore(score, timeElapsed, difficulty, badge) {
            try {
                const response = await fetch('/Projet_Memory/controllers/GameController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        score,
                        timeElapsed,
                        difficulty,
                        badge
                    })
                });
                
                const data = await response.json();
                if (!data.success) {
                    console.error('Erreur lors de la sauvegarde du score:', data.message);
                }
            } catch (error) {
                console.error('Erreur:', error);
            }
        }

        function disableCards() {
            firstCard.removeEventListener('click', flipCard);
            secondCard.removeEventListener('click', flipCard);
            resetBoard();
        }

        function unflipCards() {
            lockBoard = true;
            setTimeout(() => {
                firstCard.classList.remove('flipped');
                secondCard.classList.remove('flipped');
                resetBoard();
            }, 1500);
        }

        function resetBoard() {
            [hasFlippedCard, lockBoard] = [false, false];
            [firstCard, secondCard] = [null, null];
        }

        async function saveScore(score, timeUsed, difficulty, badge) {
            try {
                await fetch('/Projet_Memory/controllers/GameController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        score,
                        timeUsed,
                        difficulty,
                        badge
                    })
                });
            } catch (error) {
                console.error('Erreur lors de la sauvegarde du score:', error);
            }
        }

        function initializeGame() {
            const settings = DIFFICULTY_SETTINGS[currentDifficulty];
            const gameGrid = document.getElementById('gameGrid');
            gameGrid.className = `grid gap-4 max-w-6xl mx-auto p-8 bg-gray-800/30 rounded-2xl backdrop-blur-sm grid-cols-${settings.cols}`;
            
           
            const totalPairs = (settings.rows * settings.cols) / 2;
            let cards = [
                'abricot', 'banane', 'cerise', 'citron-vert', 'citron', 'clementine',
                'fraise', 'framboise', 'fruit-de-la-passion', 'groseille', 'mangue', 'mirabelle',
                'pasteque', 'peche', 'poire', 'pomme-verte', 'pomme', 'raisin'
            ].slice(0, totalPairs);
            
            cards = [...cards, ...cards]; 
            cards.sort(() => Math.random() - 0.5); 
            
            
            gameGrid.innerHTML = '';
            
 
            cards.forEach(card => {
                const cardElement = `
                    <div class='memory-card aspect-square rounded-xl relative' data-framework='${card}'>
                        <div class='card-front absolute inset-0 bg-white rounded-xl flex items-center justify-center p-2'>
                            <img src='/Projet_Memory/Projet_Memory/assets/images/${card}.png' 
                                 alt='${card}' 
                                 class='w-full h-full object-contain'>
                        </div>
                        <div class='card-back absolute inset-0'></div>
                    </div>`;
                gameGrid.innerHTML += cardElement;
            });

     
            document.querySelectorAll('.memory-card').forEach(card => {
                card.addEventListener('click', () => {
                    startTimer();
                    flipCard.call(card);
                });
            });
        }

        
        document.querySelectorAll('button[onclick="resetGame()"]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                resetGame();
            });
        });

        window.addEventListener('load', () => {
            setDifficulty();
            initializeGame();
        });

        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', () => {
                card.classList.toggle('flipped');
            });
        });
    </script>
</body>
</html>
