<?php
require_once 'common.php';
if (AuthController::isStudent()) {
    $controller = new StudentController();

    if (!isset($_GET['id'])) {
        $_SESSION['flash']['error'] = "Tutor ID missing.";
        header('Location: ' . BASE_URL . 'find_tutor.php');
        exit;
    }
    $controller->viewTutor($_GET['id']);
} else {
    header('Location: ' . BASE_URL . 'login.php');
}
