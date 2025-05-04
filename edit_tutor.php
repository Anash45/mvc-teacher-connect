<?php
require_once 'common.php';
if (AuthController::isAdmin() && isset($_REQUEST['id'])) {
    $controller = new AdminController();
    $id = $_REQUEST['id'];
    $controller->editTutor($id);
} else {
    header('Location: ' . BASE_URL . 'login.php');
}
