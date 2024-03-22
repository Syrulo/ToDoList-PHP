<?php

namespace App\Todolist\Repository;

use App\Todolist\Services\Database;

/**
 * gère l'interaction avec la table "task" de la BDD
 */
class TaskRepository
{
    /**
     * récupère une liste de tâches
     *
     * @return array $task une collection de tâches
     */
    public function index(): array
    {
        $pdo = new Database(
            "127.0.0.1",
            "todolist",
            "3306",
            "root",
            ""
        );
        $tasks =  $pdo->selectAll("SELECT * FROM task");
        return $tasks;
    }

    /**
     * ajoute une tâche dans la table
     *
     * @return void
     */
    public function add(string $title, string $status)
    {
        $pdo = new Database(
            "127.0.0.1",
            "todolist",
            "3306",
            "root",
            ""
        );
        $pdo->query("INSERT INTO task (title, status) VALUES (?, ?)", [$title, $status]);
    }

    /**
     * récupère une tâche en particulier
     * 
     * @param integer $id
     * @return array $task
     */
    public function show(int $id): array
    {
        $pdo = new Database(
            "127.0.0.1",
            "todolist",
            "3306",
            "root",
            ""
        );
        return $pdo->select("SELECT * FROM task WHERE id= $id");
    }

    /**
     * supprime une tâche en particulier
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        $pdo = new Database(
            "127.0.0.1",
            "todolist",
            "3306",
            "root",
            ""
        );
        return $pdo->query("DELETE FROM task WHERE id = " . $id);
    }

    /**
     * modifie une tâche en particulier
     *
     * @param integer $id
     * @param string $title
     * @param string $description
     * @return void
     */
    public function update(int $id, string $title, string $description)
    {
        $pdo = new Database(
            "127.0.0.1",
            "todolist",
            "3306",
            "root",
            ""
        );
        $pdo->query("UPDATE task set title = :title, description = :description WHERE id = " . $id, ['title' => $title, 'description' => $description]);
    }

    public function updateStatus(int $id, array $task)
    {
        $pdo = new Database(
            "127.0.0.1",
            "todolist",
            "3306",
            "root",
            ""
        );
        $status = $task['status'];
        if($status == "en attente"){
            $status = "en cours";
        }
        else if($status == "en cours"){
            $status = "terminé";
        }
        $pdo->query("UPDATE task set status = '$status' WHERE id = $id");
    }
}
