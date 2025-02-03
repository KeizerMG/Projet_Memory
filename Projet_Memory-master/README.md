## Installation

1. Clonez le dépôt GitHub :
   ```sh
   git clone https://github.com/KeizerMG/Projet_Memory.git
   cd Projet_Memory
   ```

2. Installez les dépendances via Composer :
   ```sh
   composer install
   ```

3. Configurez les informations de connexion à la base de données dans `config/database.php` :
   ```php
   $host = "localhost";
   $dbname = "memory_game";
   $username = "root";
   $password = "";
   ```

4. Exécutez le script d'installation pour configurer la base de données :
   ```sh
   php install.php
   ```

5. Remplissez la base de données avec des données factices en exécutant le script suivant :
   ```sh
   php scripts/fixture.php
   ```

6. Accédez au projet dans votre navigateur :
   ```sh
   http://localhost/Projet_Memory-master
   ```

## Fonctionnalités

- **Inscription** : Les utilisateurs peuvent s'inscrire avec un nom d'utilisateur, un email et un mot de passe.
- **Connexion** : Les utilisateurs peuvent se connecter avec leur nom d'utilisateur et leur mot de passe.
- **Jeu de mémoire** : Les utilisateurs peuvent jouer au jeu de mémoire avec différents niveaux de difficulté.
- **Meilleurs scores** : Les utilisateurs peuvent consulter les meilleurs scores.

## Structure du projet

- `index.php` : Point d'entrée principal de l'application.
- `config/database.php` : Configuration de la connexion à la base de données.
- `controllers/` : Contient les contrôleurs pour la gestion des utilisateurs et des scores.
- `models/` : Contient les modèles pour interagir avec la base de données.
- `views/` : Contient les fichiers de vue pour l'interface utilisateur.
- `scripts/fixture.php` : Script pour remplir la base de données avec des données factices.
- `database/memory_game.sql` : Fichier SQL pour créer les tables de la base de données.

