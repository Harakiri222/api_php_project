<?php

namespace Models;

use PDO;

class Comment {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllComments() {
        $stmt = $this->pdo->query("SELECT * FROM comments");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentsByPost($postId) {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE post_id = :post_id");
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createComment($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO comments (content, user_id, post_id)
            VALUES (:content, :user_id, :post_id)
        ");
        $stmt->execute([
            'content' => $data['content'],
            'user_id' => $data['user_id'],
            'post_id' => $data['post_id']
        ]);
        return $this->pdo->lastInsertId();
    }
}