<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Gère la connexion à la base de données avec PDO.
 *
 * Les modèles héritent de cette classe : ils disposent ainsi
 * automatiquement d'une connexion dans la propriété $db.
 */
class DbConnect
{
    /**
     * Connexion PDO, accessible uniquement aux classes filles (les modèles).
     */
    protected PDO $db;

    /**
     * Ouvre la connexion à la base de données animelo.
     *
     * Le mode ERRMODE_EXCEPTION fait remonter toute erreur SQL
     * sous forme d'exception.
     */
    public function __construct()
    {
        // Paramètres de connexion en environnement de développement local
        $host = '127.0.0.1';
        $dbname = 'animelo';
        $user = 'root';
        $password = '';

        try {
            $this->db = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
}
