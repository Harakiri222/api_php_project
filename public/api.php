<?php

require_once __DIR__ . '/../vendor/autoload.php';
$pdo = require_once __DIR__ . '/../config/database.php';

use Controllers\UserController;
use Controllers\PostController;
use Controllers\CommentController;

$action = $_GET['action'] ?? null;

switch ($action) {
    case 'getUsers':
        $controller = new UserController($pdo);
        $controller->index();
        break;

    case 'getUser':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'Параметр id не передан']);
        } else {
            $controller = new UserController($pdo);
            $controller->getById($id);
        }
        break;

    case 'createUser':
        $data = [
            'name'     => $_POST['name'] ?? '',
            'email'    => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? ''
        ];
        $controller = new UserController($pdo);
        $controller->create($data);
        break;

    case 'getPosts':
        $controller = new PostController($pdo);
        $controller->index();
        break;

    case 'getPost':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'Параметр id не передан']);
        } else {
            $controller = new PostController($pdo);
            $controller->getById($id);
        }
        break;

    case 'getUserPosts':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'Параметр id не передан']);
        } else {
            $controller = new PostController($pdo);
            $controller->getPostsByUser($id);
        }
        break;

    case 'createPost':
        $data = [
            'title'   => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? '',
            'user_id' => $_POST['user_id'] ?? ''
        ];
        $controller = new PostController($pdo);
        $controller->create($data);
        break;

    case 'getComments':
        $controller = new CommentController($pdo);
        $controller->index();
        break;

    case 'getPostComments':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'Параметр id не передан']);
            break;
        }
        $controller = new CommentController($pdo);
        $controller->getCommentsByPost($id);
        break;

    case 'getCommentsCount':
        $stmt = $pdo->query("
                SELECT u.id, u.name, COUNT(c.id) AS comment_count 
                FROM users u 
                LEFT JOIN comments c ON u.id = c.user_id 
                GROUP BY u.id, u.name
            ");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
        break;

    case 'createComment':
        $data = [
            'content' => $_POST['content'] ?? '',
            'user_id' => $_POST['user_id'] ?? '',
            'post_id' => $_POST['post_id'] ?? ''
        ];
        $controller = new CommentController($pdo);
        $controller->create($data);
        break;

    default:
        echo json_encode(['error' => 'Неверное действие']);
        break;
}