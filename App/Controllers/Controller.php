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
}