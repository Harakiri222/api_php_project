<?php

namespace Controllers;

use Models\User;

class UserController {
    private User $userModel;

    public function __construct($pdo) {
        if (!$pdo instanceof \PDO) {
            die('Передан неверный объект PDO');
        }

        $this->userModel = new User($pdo);
    }

    public function index() : void {
        $users = $this->userModel->getAllUsers();
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($users, JSON_UNESCAPED_UNICODE);
    }

    public function create($data) : void {
        $newUserId = $this->userModel->createUser($data);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['id' => $newUserId]);
    }

    public function getById($id) : void {
        $user = $this->userModel->getById($id);

        if ($user) {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($user, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Пользователь не найден']);
        }
    }
}