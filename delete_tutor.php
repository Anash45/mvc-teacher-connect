<?php
require_once 'common.php';
if (AuthController::isAdmin()) {
    $controller = new AdminController();
    $controller->deleteTutor();

} else {
    header('Location: ' . BASE_URL . 'login.php');
}
