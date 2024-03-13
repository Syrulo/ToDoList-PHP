<?php
namespace App\Todolist;

use App\Todolist\Controllers\HomeController;
use App\Todolist\Controllers\TaskController;
use App\Todolist\Controllers\ContactController;

class Router{
    public function index(){
        $routes = [
            '/' => [
                'controller' => 'HomeController@index',
                'method' => 'GET'
            ],
            '/task' => [
                'controller' => 'TaskController@index',
                'method' => 'GET'
            ],
            '/task/new' => [
                'controller' => 'TaskController@new',
                'method' => 'POST'
            ],
            '/task/:id' => [
                'controller' => 'TaskController@show',
                'method' => 'GET'
            ],
            '/contact' => [
                'controller' => 'ContactController@index',
                'method' => 'GET'
            ],
            '/task/delete/:id' => [
                'controller' => 'TaskController@delete',
                'method' => 'GET'
            ],
        ];
        // Récupérer l'URL demandée
        $url = $_SERVER['REQUEST_URI'];
        // Trouver le controller et la méthode correspondante
        if($url === "/todo_list/public/task/"){
        // Instancier le contrôleur et appeler la méthode
        $controller = new TaskController();
        $controller->index();
        }

        if($url === "/todo_list/public/"){
            // Instancier le contrôleur et appeler la méthode
            $controller = new HomeController();
            $controller->index();
        }

        $parts = explode('/',$url); // http://localhost/todo_list/public/task/new/
        if(array_key_exists(4, $parts) && $parts[3] === "task" && $parts[2] === "public" && $parts[4] === "new"){
            // Instancier le contrôleur et appeler la méthode
            $controller = new TaskController();
            $controller->new();
        }

        $parts = explode('/',$url);    http://localhost/todo_list/public/task/show/2
        if(array_key_exists(5, $parts) && $parts[5] !== "" && $parts[3] === "task" && $parts[4] === "show"){
            // Instancier le contrôleur et appeler la méthode
            $controller = new TaskController();
            $controller->show((int)$parts[5]);
        }

        if ($url === "/todo_list/public/contact/"){
            $controller = new ContactController();
            $controller -> index();    
        }

        $parts = explode('/',$url);
        if(array_key_exists(5, $parts) && $parts[5] !== "" && $parts[3] === "task" && $parts[4] === "delete"){
            // Instancier le contrôleur et appeler la méthode
            $controller = new TaskController();
            $controller->delete((int)$parts[5]);
        }

        $parts = explode('/',$url); //http://localhost/todo_list/public/task/update/2
        if(array_key_exists(5, $parts) && (int)$parts[5] && $parts[4] === "update" && $parts[3] === "task"){
            // Instancier le contrôleur et appeler la méthode
            $controller = new TaskController();
            $controller->update((int)$parts[5]);
        }

        // $parts = explode('/',$url); // http://localhost/todo_list/public/task/update/status/2
        if(array_key_exists(6, $parts) && (int)$parts[6] && $parts[5] === "status" && $parts[3] === "task" && $parts[4] === "update"){
            // Instancier le contrôleur et appeler la méthode
            $id = (int)$parts[6];
            $controller = new TaskController();
            $controller->updateStatus($id);
        }
        
}
}