<?php

namespace App;

/**
 * Charge automatiquement les classes de l'application.
 *
 * Convertit le nom complet d'une classe (avec son namespace) en chemin
 * de fichier : il n'est donc pas nécessaire d'écrire un require par classe.
 */
class Autoloader
{
    /**
     * Enregistre la méthode autoload() auprès de PHP.
     */
    public static function register()
    {
        spl_autoload_register([self::class, 'autoload']);
    }

    /**
     * Charge le fichier correspondant à une classe.
     *
     * Exemple : App\Controllers\PostController devient
     * App/Controllers/PostController.php.
     *
     * @param string $class Nom complet de la classe, avec son namespace
     */
    public static function autoload($class)
    {
        $class = str_replace('App\\', '', $class);
        $class = str_replace('\\', '/', $class);
        $file = __DIR__ . '/App/' . $class . '.php';

        if (file_exists($file)) {
            require $file;
        }
    }
}