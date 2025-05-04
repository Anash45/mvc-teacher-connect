<?php
require_once 'common.php';
if (AuthController::isStudent()) {
    $controller = new StudentController();
    $controller->findTutor();
} else {
    header('Location: ' . BASE_URL . 'login.php');
}
