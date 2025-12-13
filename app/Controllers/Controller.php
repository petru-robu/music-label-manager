<?php

require_once __DIR__ . '/../Core/View.php';

class Controller
{
    protected function render(string $view, array $data = [], string $title = ''): void
    {
        View::render($view, $data, $title);
    }
}
