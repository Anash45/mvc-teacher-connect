<?php
require_once 'common.php';
if (AuthController::isAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requestId = $_POST['request_id'];
        $status = $_POST['status'];

        $adminModel = new AdminModel();
        $adminModel->updateRequestStatus($requestId, $status);

        header('Location: admin_dashboard.php');
        exit;
    }
} else {
    header('Location: ' . BASE_URL . 'login.php');
}
