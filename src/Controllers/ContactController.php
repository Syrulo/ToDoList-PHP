<?php
namespace App\Todolist\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class ContactController
{
    public function index()
    {

        $loader = new FilesystemLoader("../Templates");
        // initialiser twig
        $twig = new Environment($loader);
        //Rendre une vue
        echo $twig->render('contact.twig', ['name' => 'Thomas']);
        echo "page de contact";
    }   
}