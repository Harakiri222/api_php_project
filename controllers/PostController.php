<?php

namespace Controllers;

use Models\Post;

class PostController {
    private Post $postModel;

    public function __construct($pdo) {
        $this->postModel = new Post($pdo);
    }

    public function index() : void {
        $posts = $this->postModel->getAllPosts();
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($posts, JSON_UNESCAPED_UNICODE);
    }

    public function create($data) : void {
        $newPostId = $this->postModel->createPost($data);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['id' => $newPostId]);
    }

    public function getById($id) : void {
        $post = $this->postModel->getById($id);

        if ($post) {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($post, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Пост не найден']);
        }
    }

    public function getPostsByUser($userId) : void {
        $posts = $this->postModel->getPostsByUser($userId);

        if ($posts) {
            header('Content-Type: application/json');
            echo json_encode($posts);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Посты пользователя не найдены']);
        }
    }
}