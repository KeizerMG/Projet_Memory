<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        .form-container {
            backdrop-filter: blur(8px);
            border-radius: 1rem;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="absolute top-4 left-4">
        <a href="/Projet_Memory/views/home.php" 
           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
            Meilleurs scores
        </a>
    </div>
    <div class="bg-gray-800/50 p-8 rounded-2xl backdrop-blur-xl w-96 shadow-xl form-container">
        <h2 class="text-3xl font-bold text-center mb-8 text-white">Connexion</h2>
        <form id="loginForm" class="space-y-6">
            <div class="space-y-2">
                <label for="username" class="text-gray-300 block">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required 
                    class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all"
                    autocomplete="username">
            </div>
            <div class="space-y-2">
                <label for="password" class="text-gray-300 block">Mot de passe</label>
                <input type="password" id="password" name="password" required 
                    class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <button type="submit" 
                class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all">
                Se connecter
            </button>
        </form>
        <p class="mt-6 text-center text-gray-400">
            Pas encore de compte ? 
            <a href="/Projet_Memory/views/auth/register.php" class="text-blue-400 hover:text-blue-300">S'inscrire</a>
        </p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            try {
                const response = await fetch('/Projet_Memory/controllers/AuthController.php?action=login', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Toastify({
                        text: "Connexion réussie !",
                        duration: 2000,
                        gravity: "top",
                        position: "center",
                        style: {
                            background: "linear-gradient(to right, #10B981, #059669)",
                            borderRadius: "8px",
                            padding: "16px",
                        }
                    }).showToast();

                    setTimeout(() => {
                        window.location.href = '/Projet_Memory/index.php?page=game';
                    }, 2000);
                } else {
                    Toastify({
                        text: data.message || "Erreur de connexion",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        style: {
                            background: "linear-gradient(to right, #EF4444, #DC2626)",
                            borderRadius: "8px",
                            padding: "16px",
                        }
                    }).showToast();
                }
            } catch (error) {
                Toastify({
                    text: "Erreur lors de la connexion",
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "linear-gradient(to right, #EF4444, #DC2626)",
                        borderRadius: "8px",
                        padding: "16px",
                    }
                }).showToast();
            }
        });
    </script>
</body>
</html>
