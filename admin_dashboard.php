<?php
require_once 'common.php';
if (AuthController::isAdmin()) {
    $controller = new AdminController();
    $controller->index();
} else {
    header('Location: ' . BASE_URL . 'login.php');
}
