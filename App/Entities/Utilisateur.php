<?php

namespace App\Entities;

/**
 * Représente un utilisateur.
 *
 * Simple objet de données, sans logique : il est rempli
 * par UtilisateurModel à partir d'une ligne de la table utilisateurs.
 */
class Utilisateur
{
    public ?int $id = null;
    public string $nom = '';
    public string $email = '';
    /** Hachage du mot de passe (jamais le mot de passe en clair) */
    public string $motDePasse = '';
    /** Nom du fichier de la photo de profil, ou null si aucune photo */
    public ?string $photoProfil = null;
    public ?string $dateCreation = null;
}
