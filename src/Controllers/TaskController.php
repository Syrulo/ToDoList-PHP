<?php
namespace App\Todolist\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Todolist\Repository\TaskRepository;

class TaskController extends AbstractController{
    public function index()
    {
        $taskRepository = new TaskRepository();
        $tasks = $taskRepository->index();
        $this->render('tasklist.twig', [
        'tasks' => $tasks,
        'name' => 'Thomas'
        ]);
    }

    public function new()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $title = $_POST['title'];
            $status = $_POST['status'];
            $status = "en attente";
            $taskRepository = new TaskRepository();
            $taskRepository->add($title, $status);
            header('location: http://localhost/todo_list/public/task/');
            }
        $this->render('taskadd.twig', [ ]);
    }
    public function show(int $id)
    {
        // déterminer le dossier qui va contenir les fichiers twig
        $loader = new FilesystemLoader("../Templates");
        // initialiser twig
        $twig = new Environment($loader);
        $taskRepository = new TaskRepository();
        $task = $taskRepository->show($id);
        // rendre une vue
        $this->render('taskview.twig', [
            'task' => $task
        ]);
    }

    public function delete(int $id) 
    {
        $taskRepository = new TaskRepository();
        $task = $taskRepository->delete($id);   
        header('location: http://localhost/todo_list/public/task/');    
    }

    public function update(int $id) 
    {       
        $taskRepository = new TaskRepository();
        $task = $taskRepository->show($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $title = $_POST['title'];
            $description = $_POST['description'];
            $taskRepository->update($id, $title, $description);
            header('location: http://localhost/todo_list/public/task/');
            
        }  
        $this->render('taskupdate.twig', [
            'task' => $task,
        ]);
    }

    public function updateStatus(int $id) 
    {    
        $taskRepository = new TaskRepository();
        $task = $taskRepository->show($id);
        $taskRepository->updateStatus($id, $task); 
        header("Location: http://localhost/todo_list/public/task/");      
    }  
}
