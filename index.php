<?php
session_start();
print_r($_SESSION);
define('BASE_URL', '/david/p4/');

// Load core files
require_once './core/Controller.php';
require_once './core/Database.php';
require_once './core/Model.php';


require_once './app/controllers/HomeController.php';
require_once './app/controllers/AuthController.php';
require_once './app/controllers/StudentController.php';
require_once './app/controllers/AdminController.php';

// Routing logic
$url = $_GET['url'] ?? '';

switch ($url) {
    case '':
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    case 'signup':
        $controller = new AuthController();
        $controller->signup();
        break;

    case 'student_dashboard':
        if (AuthController::isStudent()) {
            $controller = new StudentController();
            $controller->index();
        } else {
            header('location:' . BASE_URL);
        }
        break;

    case 'admin_dashboard':
        if (AuthController::isAdmin()) {
            $controller = new AdminController();
            $controller->index();
        } else {
            header('location:' . BASE_URL);
        }
        break;

    case 'add_tutor':
        if (AuthController::isAdmin()) {
            $controller = new AdminController();
            $controller->addTutor();
        } else {
            header('location:' . BASE_URL);
        }
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    default:
        echo "404 - Page not found";
        break;
}
