<?php
namespace App\Todolist\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Todolist\Services\Database;

class HomeController{
    public function index()
    {
        // déterminer le dossier qui va contenir les fichiers twig
        $loader = new FilesystemLoader("../Templates");
        // initialiser twig
        $twig = new Environment($loader);
        $pdo = new Database(
            "127.0.0.1",
            "todolist", 
            "3306", 
            "root",
            "");
            $tasks = $pdo->selectAll( "SELECT * FROM task");
        // rendre une vue
        echo $twig->render('homepage.twig', [
            'name'=> 'Thomas',
            'tasks' => $tasks
        ]);
    }
}