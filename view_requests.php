<?php
require_once 'common.php';
if (AuthController::isStudent()) {
    $controller = new StudentController();
    $controller->viewRequests();
} else {
    header('Location: ' . BASE_URL . 'login.php');
}
