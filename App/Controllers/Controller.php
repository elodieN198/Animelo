<?php

namespace App\Controllers;

abstract class Controller
{
    protected function render(string $view, array $data = [])
    {
        extract($data);

        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("Erreur : la vue $viewPath n'existe pas.");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        $title = $data['title'] ?? 'Animelo';

        require __DIR__ . '/../Views/base.php';
    }

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