<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\Utilisateur;
use PDO;

/**
 * Accès aux données de la table utilisateurs.
 *
 * Toutes les requêtes sont préparées avec PDO pour éviter les injections SQL.
 */
class UtilisateurModel extends DbConnect
{
    /**
     * Recherche un utilisateur par son adresse email.
     *
     * @param string $email Adresse email recherchée
     * @return Utilisateur|null L'utilisateur trouvé, ou null s'il n'existe pas
     */
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

    /**
     * Recherche un utilisateur par son identifiant.
     *
     * @param int $id Identifiant de l'utilisateur
     * @return Utilisateur|null L'utilisateur trouvé, ou null s'il n'existe pas
     */
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

    /**
     * Crée un nouveau compte utilisateur.
     *
     * @param string $nom             Nom de l'utilisateur
     * @param string $email           Adresse email (unique en base)
     * @param string $motDePasseHache Mot de passe déjà haché avec password_hash()
     * @return int Identifiant généré pour le nouvel utilisateur
     */
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

    /**
     * Met à jour la photo de profil d'un utilisateur.
     *
     * @param int    $id         Identifiant de l'utilisateur
     * @param string $nomFichier Nom du fichier image enregistré dans public/uploads
     */
    public function updatePhotoProfil(int $id, string $nomFichier): void
    {
        $stmt = $this->db->prepare('UPDATE utilisateurs SET photo_profil = :photo WHERE id = :id');
        $stmt->execute(['photo' => $nomFichier, 'id' => $id]);
    }

    /**
     * Transforme une ligne de la base en objet Utilisateur.
     *
     * Les noms de colonnes en snake_case (mot_de_passe) deviennent
     * des propriétés en camelCase (motDePasse).
     *
     * @param array $row Ligne issue de la base de données
     * @return Utilisateur
     */
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
