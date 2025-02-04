## Installation

1. Clonez le dépôt GitHub :
    ```bash
    git clone https://github.com/KeizerMG/Projet_Memory.git
    ```

2. Accédez au répertoire du projet :
    ```bash
    cd Projet_Memory
    ```

3. Installez les dépendances PHP avec Composer :
    ```bash
    composer install
    ```

4. Configurez la base de données :
    - Créez une base de données MySQL nommée `memory_game`.
    - Importez le fichier SQL pour créer les tables et insérer des utilisateurs factices :
        


6. Lancez le serveur web et accédez au projet via votre navigateur :
    ```bash
    http://localhost/Projet_Memory/index.php
    ```

## Utilisation

1. Accédez à la page d'accueil pour voir les meilleurs scores.
2. Inscrivez-vous en cliquant sur "S'inscrire" et en remplissant le formulaire d'inscription.
3. Connectez-vous avec vos identifiants.
4. Jouez au jeu en cliquant sur "Jouer au jeu".

## Développement

Pour remplir la base de données avec des utilisateurs et des scores factices, accédez à l'URL suivante :
```bash
http://localhost/Projet_Memory/index.php?action=fill_database
```
