<?php
namespace App\Todolist\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AbstractController
{
    protected function render(string $template, array $data)
    {
        $loader = new FilesystemLoader("../Templates");
        // initialiser twig
        $twig = new Environment($loader);
        echo $twig->render($template, $data);
    }
}