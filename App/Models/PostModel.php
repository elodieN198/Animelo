<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\Post;
use PDO;

/**
 * Accès aux données de la table posts.
 *
 * Toutes les requêtes sont préparées avec PDO pour éviter les injections SQL.
 */
class PostModel extends DbConnect
{
    /**
     * Enregistre une nouvelle publication.
     *
     * @param string      $titreAnime    Titre de l'animé
     * @param string      $description   Avis de l'utilisateur
     * @param string|null $image         Nom du fichier image, ou null
     * @param int         $utilisateurId Identifiant de l'auteur
     * @return int Identifiant généré pour le nouveau post
     */
    public function create(string $titreAnime, string $description, ?string $image, int $utilisateurId): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO posts (titre_anime, description, image, utilisateur_id) 
             VALUES (:titreAnime, :description, :image, :utilisateurId)'
        );
        $stmt->execute([
            'titreAnime' => $titreAnime,
            'description' => $description,
            'image' => $image,
            'utilisateurId' => $utilisateurId,
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Récupère les publications avec le nom de leur auteur.
     *
     * @param string $tri       'likes' pour trier par nombre de likes, sinon par date
     * @param string $recherche Texte recherché dans le titre de l'animé
     * @return Post[] Liste des publications
     */
    public function findAll(string $tri = 'date', string $recherche = ''): array
    {
        $sql = 'SELECT posts.*, utilisateurs.nom AS auteur_nom 
                FROM posts 
                JOIN utilisateurs ON posts.utilisateur_id = utilisateurs.id';

        $params = [];

        if ($recherche !== '') {
            $sql .= ' WHERE posts.titre_anime LIKE :recherche';
            $params['recherche'] = '%' . $recherche . '%';
        }

        if ($tri === 'likes') {
            $sql .= ' ORDER BY posts.nb_likes DESC';
        } else {
            $sql .= ' ORDER BY posts.date_creation DESC';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'hydrate'], $rows);
    }

    /**
     * Récupère les publications d'un utilisateur, de la plus récente
     * à la plus ancienne.
     *
     * @param int $utilisateurId Identifiant de l'auteur
     * @return Post[] Liste des publications
     */
    public function findByUser(int $utilisateurId): array
    {
        $stmt = $this->db->prepare(
            'SELECT posts.*, utilisateurs.nom AS auteur_nom 
             FROM posts 
             JOIN utilisateurs ON posts.utilisateur_id = utilisateurs.id
             WHERE posts.utilisateur_id = :utilisateurId
             ORDER BY posts.date_creation DESC'
        );
        $stmt->execute(['utilisateurId' => $utilisateurId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'hydrate'], $rows);
    }

    /**
     * Recherche une publication par son identifiant.
     *
     * @param int $id Identifiant du post
     * @return Post|null Le post trouvé, ou null s'il n'existe pas
     */
    public function findById(int $id): ?Post
    {
        $stmt = $this->db->prepare(
            'SELECT posts.*, utilisateurs.nom AS auteur_nom 
             FROM posts 
             JOIN utilisateurs ON posts.utilisateur_id = utilisateurs.id
             WHERE posts.id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    /**
     * Ajoute un like à une publication et renvoie le nouveau total.
     *
     * @param int $postId Identifiant du post
     * @return int Nouveau nombre de likes
     */
    public function incrementerLikes(int $postId): int
    {
        $stmt = $this->db->prepare('UPDATE posts SET nb_likes = nb_likes + 1 WHERE id = :id');
        $stmt->execute(['id' => $postId]);

        $stmt = $this->db->prepare('SELECT nb_likes FROM posts WHERE id = :id');
        $stmt->execute(['id' => $postId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Supprime une publication.
     *
     * La vérification de l'auteur est faite avant, par le contrôleur.
     *
     * @param int $id Identifiant du post
     */
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    /**
     * Transforme une ligne de la base en objet Post.
     *
     * @param array $row Ligne issue de la base de données
     * @return Post
     */
    private function hydrate(array $row): Post
    {
        $post = new Post();
        $post->id = (int) $row['id'];
        $post->titreAnime = $row['titre_anime'];
        $post->description = $row['description'];
        $post->image = $row['image'];
        $post->nbLikes = (int) $row['nb_likes'];
        $post->utilisateurId = (int) $row['utilisateur_id'];
        $post->dateCreation = $row['date_creation'];
        $post->auteurNom = $row['auteur_nom'] ?? null;

        return $post;
    }
}