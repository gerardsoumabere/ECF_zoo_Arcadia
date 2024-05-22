# ECF_zoo_Arcadia

## # Ce projet est une application web interactive pour le zoo Arcadia, permettant aux visiteurs de découvrir les animaux et les habitats en ligne, et aux administrateurs de gérer les informations et les utilisateurs.

## Prérequis

### # Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine :

- PHP (version 8.O ou supérieure)
- Composer
- MySQL (ou une autre base de données relationnelle)
- MongoDB (pour les données NoSQL)
- 

## Configuration de l’Environnement de Développement

### 1. Cloner le Dépôt

#### # Clonez le dépôt GitHub du projet :
git clone https://github.com/gerardsoumabere/ECF_zoo_Arcadia.git
cd zoo-arcadia
composer install

### 2. Configuration de la Base de Données MySQL
#### # Personnalisez le fichier dbconfig.php dans app/config/dbconfig.php :
define('DB_HOST', 'localhost'); // Nom du serveur MySQL (généralement localhost)
define('DB_USERNAME', 'root'); // Nom d'utilisateur MySQL par défaut (généralement root)
define('DB_PASSWORD', ''); // Mot de passe MySQL par défaut (laisser vide par défaut)
define('DB_NAME', 'ecf_zoo_arcadia'); // Nom de la base de données à laquelle se connecter

Créez une base de données MySQL (via PHPMyAdmin par exemple) ou laissez le script la créer pour vous automatiquement.

Importez le schéma de base de données fourni dans le fichier zoo_arcadia.sql : [text](app/config/zoo_arcadia.sql)

mysql -u root -p ecf_zoo_arcadia < app/config/zoo_arcadia.sql

#### # Fixtures 

Des données sont automatiquement intégrées à la base s'il n' y en a pas par la fonction loadFixtures dans dbconnect.php

### 3. Configuration de la Base de Données NoSQL (MongoDB)
#### # Assurez-vous que MongoDB est en cours d’exécution :
mongod

Créez une base de données MongoDB et ajoutez les collections nécessaires :

use zoo_arcadia;
db.createCollection("collection_name");

### 4. Démarrage de l’Application en Développement
#### Installation de Wamp
Téléchargez le package d'installation de Wamp [depuis le site](https://wampserver.aviatechno.net/) 

Exécutez le fichier d'installation téléchargé et suivez les instructions à l'écran pour installer Wamp sur votre système.

Une fois l'installation terminée, lancez Wamp. Assurez-vous que les services Apache et MySQL sont démarrés.

### 5. Déploiement en Production
Pour déployer l’application en production, suivez les instructions spécifiques de votre service d’hébergement.
Des captures d'écran pour l'hebergeur 02Switch sont disponible dans docs\Procédure hébergeur 02SWITCH.pdf pour vous aider.