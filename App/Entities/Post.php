<?php

namespace App\Entities;

class Post
{
    public ?int $id = null;
    public string $titreAnime = '';
    public string $description = '';
    public ?string $image = null;
    public int $nbLikes = 0;
    public int $utilisateurId = 0;
    public ?string $dateCreation = null;
    public ?string $auteurNom = null;
}