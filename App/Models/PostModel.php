<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\Post;
use PDO;

class PostModel extends DbConnect
{
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

    public function incrementerLikes(int $postId): int
    {
        $stmt = $this->db->prepare('UPDATE posts SET nb_likes = nb_likes + 1 WHERE id = :id');
        $stmt->execute(['id' => $postId]);

        $stmt = $this->db->prepare('SELECT nb_likes FROM posts WHERE id = :id');
        $stmt->execute(['id' => $postId]);

        return (int) $stmt->fetchColumn();
    }

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