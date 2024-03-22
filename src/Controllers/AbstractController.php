<?php
namespace App\Todolist\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Abstrait les controllers
 */

class AbstractController
{
    /**
     * affiche une vue twig
     *
     * @param string $template
     * @param array $data
     * @return void
     */
    protected function render(string $template, array $data)
    {
        // echo "page d'accueil";
        $loader = new FilesystemLoader("../Templates");
        // initialiser twig
        $twig = new Environment($loader);
        echo $twig->render($template, $data);
    }
}