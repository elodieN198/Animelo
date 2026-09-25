<?php

namespace App\Entities;

/**
 * Représente une publication.
 *
 * Simple objet de données, sans logique : il est rempli
 * par PostModel à partir d'une ligne de la table posts.
 */
class Post
{
    public ?int $id = null;
    public string $titreAnime = '';
    public string $description = '';
    /** Nom du fichier image dans public/uploads */
    public ?string $image = null;
    public int $nbLikes = 0;
    /** Identifiant de l'auteur (clé étrangère vers utilisateurs) */
    public int $utilisateurId = 0;
    public ?string $dateCreation = null;
    /** Nom de l'auteur, récupéré par jointure avec la table utilisateurs */
    public ?string $auteurNom = null;
}
