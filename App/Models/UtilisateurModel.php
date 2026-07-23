<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\Utilisateur;
use PDO;

class UtilisateurModel extends DbConnect
{
    public function findByEmail(string $email): ?Utilisateur
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateurs WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function findById(int $id): ?Utilisateur
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateurs WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function create(string $nom, string $email, string $motDePasseHache): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :motDePasse)'
        );
        $stmt->execute([
            'nom' => $nom,
            'email' => $email,
            'motDePasse' => $motDePasseHache,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updatePhotoProfil(int $id, string $nomFichier): void
    {
        $stmt = $this->db->prepare('UPDATE utilisateurs SET photo_profil = :photo WHERE id = :id');
        $stmt->execute(['photo' => $nomFichier, 'id' => $id]);
    }

    private function hydrate(array $row): Utilisateur
    {
        $utilisateur = new Utilisateur();
        $utilisateur->id = (int) $row['id'];
        $utilisateur->nom = $row['nom'];
        $utilisateur->email = $row['email'];
        $utilisateur->motDePasse = $row['mot_de_passe'];
        $utilisateur->photoProfil = $row['photo_profil'] ?? null;
        $utilisateur->dateCreation = $row['date_creation'];

        return $utilisateur;
    }
}