<?php
class StudentController extends Controller
{

    public function index()
    {
        if (!AuthController::isLoggedIn() || !AuthController::isStudent()) {
            header("Location: " . BASE_URL . "login");
            exit();
        }

        $name = $_SESSION['name'] ?? 'Student';
        $this->view('student/dashboard', [
            'name' => $name
        ]);
    }
}
