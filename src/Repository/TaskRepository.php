<?php

namespace App\Todolist\Repository;

use App\Todolist\Services\Database;

class TaskRepository
{
    public function index()
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

    public function show(int $id)
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
