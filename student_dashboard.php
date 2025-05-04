<?php
require_once 'common.php';
if (AuthController::isStudent()) {
    $controller = new StudentController();
    $controller->index();
} else {
    header('Location: ' . BASE_URL . 'login.php');
}
