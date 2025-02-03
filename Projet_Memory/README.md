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

## Manuel d'utilisation

### Remplissage de la base de données

Pour remplir la base de données avec des données factices, suivez ces étapes :

1. Assurez-vous que les informations de connexion à la base de données sont correctement configurées dans `config/database.php`.

2. Exécutez le script d'installation pour configurer la base de données :
   ```sh
   php install.php
   ```

3. Exécutez le script de fixtures pour remplir la base de données avec des données factices :
   ```sh
   php scripts/fixture.php
   ```

### Utilisation du jeu

1. Accédez au projet dans votre navigateur :
   ```sh
   http://localhost/Projet_Memory-master
   ```

2. Inscrivez-vous en tant qu'utilisateur en fournissant un nom d'utilisateur, un email et un mot de passe.

3. Connectez-vous avec vos identifiants.

4. Jouez au jeu de mémoire en sélectionnant le niveau de difficulté souhaité.

5. Consultez les meilleurs scores pour voir les performances des autres utilisateurs.

### Remplissage manuel de la base de données

Si vous souhaitez remplir manuellement la base de données avec Faker, vous pouvez également accéder à la page d'accueil du projet et cliquer sur le bouton "Remplir la base de données".

Cela exécutera le script `fixture.php` et remplira la base de données avec des utilisateurs et des scores factices.

