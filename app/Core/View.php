<?php

class View
{
    public static function render(string $view, array $data = [], string $title = ''): void
    {
        extract($data);

        require __DIR__ . '/../Views/Layout/header.php';
        require __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/Layout/footer.php';
    }
}