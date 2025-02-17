<?php

namespace Models;

use PDO;

class User {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("
            INSERT INTO users (name, email, password) 
            VALUES (:name, :email, :password)
        ");
        $stmt->execute([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $hashedPassword,
        ]);
        return $this->pdo->lastInsertId();
    }
}