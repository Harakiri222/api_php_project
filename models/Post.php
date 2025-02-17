<?php

namespace Models;

use PDO;

class Post {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllPosts() {
        $stmt = $this->pdo->query("SELECT * FROM posts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPostsByUser($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPost($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO posts (title, content, user_id) 
            VALUES (:title, :content, :user_id)
        ");
        $stmt->execute([
            'title'   => $data['title'],
            'content' => $data['content'],
            'user_id' => $data['user_id']
        ]);
        return $this->pdo->lastInsertId();
    }
}