<?php

namespace Controllers;

use Models\Comment;

class CommentController {
    private Comment $commentModel;

    public function __construct($pdo) {
        $this->commentModel = new Comment($pdo);
    }

    public function index() : void {
        $comments = $this->commentModel->getAllComments();
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($comments, JSON_UNESCAPED_UNICODE);
    }

    public function create($data) : void {
        $newCommentId = $this->commentModel->createComment($data);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['id' => $newCommentId]);
    }

    public function getCommentsByPost($postId) : void {
        $comments = $this->commentModel->getCommentsByPost($postId);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($comments, JSON_UNESCAPED_UNICODE);
    }
}