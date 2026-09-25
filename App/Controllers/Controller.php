<?php

namespace App\Controllers;

/**
 * Classe mère de tous les contrôleurs de l'application.
 *
 * Déclarée abstraite : elle ne peut pas être instanciée directement.
 * Elle centralise le comportement commun aux contrôleurs :
 * l'affichage des vues et l'affichage des pages d'erreur.
 */
abstract class Controller
{
    /**
     * Affiche une vue à l'intérieur du template commun base.php.
     *
     * Les clés du tableau $data deviennent des variables utilisables
     * dans la vue (par exemple $data['posts'] devient $posts).
     *
     * @param string $view Chemin de la vue, sans extension (ex. : 'post/index')
     * @param array  $data Données transmises à la vue
     */
    protected function render(string $view, array $data = [])
    {
        extract($data);

        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("Erreur : la vue $viewPath n'existe pas.");
        }

        // Le contenu de la vue est mis en mémoire tampon,
        // puis inséré dans le template commun via la variable $content
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        $title = $data['title'] ?? 'Animelo';

        require __DIR__ . '/../Views/base.php';
    }

    /**
     * Affiche une page d'erreur stylisée avec le code HTTP correspondant,
     * puis arrête l'exécution du script.
     *
     * @param string $message     Message affiché à l'utilisateur
     * @param int    $code        Code HTTP de la réponse (400, 403, 404...)
     * @param string $retourUrl   Adresse du bouton de retour
     * @param string $retourLabel Texte du bouton de retour
     */
    protected function erreur(
        string $message,
        int $code = 400,
        string $retourUrl = '/?controller=post&action=index',
        string $retourLabel = 'Retour au fil d\'actualité'
    ): void {
        http_response_code($code);
        $this->render('erreur', [
            'title' => 'Erreur - Animelo',
            'message' => $message,
            'retourUrl' => $retourUrl,
            'retourLabel' => $retourLabel,
        ]);
        exit;
    }
}
