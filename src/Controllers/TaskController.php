<?php
namespace App\Todolist\Controllers;

use App\Todolist\Repository\TaskRepository;
use App\Todolist\Services\Database;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * gère les routes concernants les tâches
 */
class TaskController extends AbstractController
{
    /**
     * Affiche la liste des tâches
     *
     * @return void
     */
    public function index()
    {
        $taskRepository = new TaskRepository();
        $tasks = $taskRepository->index();
        $this->render('tasklist.twig', [
        'tasks' => $tasks,
        'name' => 'Thomas'
        ]);
    }

    /**
     * permet de créer une nouvelle tâche
     * et redirige vers la liste des tâches en cas de succès
     *
     * @return void
     */
    public function new()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $title = $_POST['title'];
            $status = $_POST['status'];
            $status = "en attente";
            $taskRepository = new TaskRepository();
            $taskRepository->add($title, $status);

            // rediriger vers la page de tâches
            header('location: http://localhost/todo_list/public/task/');
            }
        $this->render('taskadd.twig', [ ]);
    }

    /**
     * permet d'afficher les détails d'une tâche en particulier
     * et redirige vers la liste des tâches en cas de succès
     *
     * @return void
     */
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

     /**
     * permet de supprimer une tâche en particulier
     * et redirige vers la liste des tâches en cas de succès
     *
     * @return void
     */
    public function delete(int $id) 
    {
        $taskRepository = new TaskRepository();
        $task = $taskRepository->delete($id);   
        header('location: http://localhost/todo_list/public/task/');    
    }

    /**
     * permet de mettre à jour une tâche en particulier
     * et redirige vers la liste des tâches en cas de succès
     *
     * @return void
     */
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
