<?php

namespace App\Core;

use PDO;
use PDOException;

class DbConnect
{
    protected PDO $db;

    public function __construct()
    {
        $host = 'localhost';
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