<?php
class StudentController extends Controller
{
    private $tutorModel;

    public function __construct()
    {
        $this->tutorModel = new TutorModel();
    }

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

    public function findTutor()
    {
        $query = $_GET['q'] ?? '';
        $tutors = $this->tutorModel->searchTutors($query);
        $this->view('student/find_tutor', ['tutors' => $tutors, 'query' => $query]);
    }
}
