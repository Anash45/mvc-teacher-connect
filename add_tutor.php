<?php
require_once 'common.php';
if (AuthController::isAdmin()) {
    $controller = new AdminController();
    $controller->addTutor();
} else {
    header('Location: ' . BASE_URL . 'login.php');
}
