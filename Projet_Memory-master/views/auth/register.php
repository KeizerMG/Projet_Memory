<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game - Inscription</title>
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
    <div class="bg-gray-800/50 p-8 rounded-2xl backdrop-blur-xl w-96 shadow-xl form-container">
        <h2 class="text-3xl font-bold text-center mb-8 text-white">Inscription</h2>
        <form id="registerForm" class="space-y-6">
            <div class="space-y-2">
                <label for="username" class="text-gray-300 block">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required 
                    class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label for="email" class="text-gray-300 block">Email</label>
                <input type="email" id="email" name="email" required 
                    class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label for="password" class="text-gray-300 block">Mot de passe</label>
                <input type="password" id="password" name="password" required 
                    class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <button type="submit" 
                class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all">
                Créer un compte
            </button>
        </form>
        <p class="mt-6 text-center text-gray-400">
            Déjà un compte ? 
            <a href="/Projet_Memory/views/auth/login.php" class="text-blue-400 hover:text-blue-300">Se connecter</a>
        </p>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            try {
                const response = await fetch('/Projet_Memory/controllers/AuthController.php?action=register', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Toastify({
                        text: "Inscription réussie ! Redirection...",
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
                        window.location.href = '/Projet_Memory/index.php?page=login';
                    }, 1000);
                } else {
                    Toastify({
                        text: data.message || "Une erreur est survenue",
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
                    text: "Une erreur est survenue lors de l'inscription",
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
