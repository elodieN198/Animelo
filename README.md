# Animelo

Plateforme de partage pour fans d'animation japonaise : chaque utilisateur publie l'animé qu'il regarde (image, titre, avis), consulte le fil d'actualité et like les publications des autres.

Projet réalisé dans le cadre du Titre Professionnel Développeur Web et Web Mobile (CEFii). Application développée et testée en local, non déployée publiquement.

## Fonctionnalités

- Inscription, connexion et déconnexion
- Publication d'un post avec image, titre de l'animé et description (aperçu de l'image avant publication)
- Fil d'actualité de tous les utilisateurs, avec fenêtre modale pour afficher un post en entier
- Like en AJAX, sans rechargement de la page
- Recherche par titre et tri par date ou par nombre de likes
- Profil avec photo et suppression de ses propres publications
- Interface responsive (ordinateur, tablette, mobile)

## Environnement technique

| Outil | Version | Rôle |
|---|---|---|
| PHP | 8.5.10 | Back-end, serveur de développement intégré (`php -S`) |
| MariaDB | 10.4.28 | Base de données (compatible MySQL), administrée avec phpMyAdmin (XAMPP) |
| Bootstrap | 5.3.3 | Interface, chargé via CDN |
| Bootstrap Icons | 1.11.3 | Icônes, chargées via CDN |

Aucune dépendance PHP externe : le back-end est écrit en PHP natif, sans Composer ni framework.

## Architecture

Architecture MVC codée à la main, en PHP orienté objet :

```
Animelo/
├── App/
│   ├── Controllers/   Contrôleurs (logique métier) : AuthController, PostController, Controller (abstraite)
│   ├── Core/          DbConnect (connexion PDO) et Router
│   ├── Entities/      Entités Post et Utilisateur
│   ├── Models/        Requêtes SQL préparées : PostModel, UtilisateurModel
│   └── Views/         Vues et template commun base.php
├── public/            Point d'entrée unique (index.php), CSS, JavaScript, images envoyées
├── database/          Script SQL de création de la base
└── Autoloader.php     Chargement automatique des classes
```

## Installation en local

### Prérequis

- PHP 8 (développé et testé avec PHP 8.5.10)
- MySQL ou MariaDB (par exemple via XAMPP)
- Git

### Étapes

1. Cloner le dépôt :

   ```
   git clone https://github.com/elodieN198/Animelo.git
   cd Animelo
   ```

2. Démarrer MySQL (et Apache pour accéder à phpMyAdmin) depuis XAMPP.

3. Dans phpMyAdmin, onglet Importer, importer le fichier `database/animelo.sql`. Il crée la base `animelo` et ses deux tables, `utilisateurs` et `posts`.

4. Vérifier que les identifiants de connexion dans `App/Core/DbConnect.php` correspondent à votre configuration locale :

   ```php
   $host = '127.0.0.1';
   $dbname = 'animelo';
   $user = 'root';
   $password = '';
   ```

5. Lancer le serveur depuis le dossier du projet :

   ```
   php -S localhost:8000 -t public
   ```

6. Ouvrir http://localhost:8000 dans le navigateur, puis créer un compte.

Le dossier `public/uploads/` doit être accessible en écriture : il reçoit les images des publications et les photos de profil.

## Sécurité

Mesures en place :

- mots de passe hachés avec `password_hash()` (bcrypt) ;
- requêtes SQL préparées avec PDO ;
- échappement des données affichées avec `htmlspecialchars()` (protection XSS) ;
- vérification du type réel des images avec `finfo_file()`, taille limitée à 5 Mo ;
- vérification de la session sur les actions réservées aux utilisateurs connectés ;
- suppression d'un post réservée à son auteur ;
- régénération de l'identifiant de session à la connexion.

Limites connues, à corriger avant toute mise en production :

- pas de protection CSRF, et suppression d'un post par lien GET ;
- pas de limite de tentatives de connexion ni d'exigence de robustesse du mot de passe ;
- extension des fichiers envoyés reprise du nom d'origine ;
- paramètres d'URL réaffichés dans les messages d'erreur du routeur.

## Mise en production

L'application n'est pas déployée. Une mise en production nécessiterait :

- un serveur web de production (Apache ou Nginx) à la place du serveur intégré de PHP ;
- le HTTPS, avec un certificat SSL/TLS (par exemple Let's Encrypt) ;
- un environnement de test (recette), identique à la production, pour valider les fonctionnalités avant leur mise en ligne ;
- des identifiants de connexion placés dans des variables d'environnement (fichier `.env` non versionné) ;
- un compte MySQL dédié, sans droits root, et des permissions d'écriture limitées au dossier `uploads/` ;
- une configuration PHP de production (erreurs détaillées masquées, OPcache activé) ;
- des logs d'erreurs et des sauvegardes régulières de la base de données ;
- la prise en compte du RGPD (mentions légales, politique de confidentialité), l'application traitant des données personnelles.

## Auteur

Elodie, projet personnel réalisé pendant la formation Développeur Web et Web Mobile au CEFii (2026).
