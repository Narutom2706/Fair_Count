<?php

namespace App\Core;

abstract class AbstractController
{
    protected function render(string $path, array $data = []): void
    {
        extract($data);
        ob_start();
        require_once __DIR__ . '/../../templates/' . $path . '.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../../templates/layout.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}