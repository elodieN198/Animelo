<?php

namespace App\Entities;

class Utilisateur
{
    public ?int $id = null;
    public string $nom = '';
    public string $email = '';
    public string $motDePasse = '';
    public ?string $dateCreation = null;
}