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

    public function viewTutor($id)
    {
        $tutorModel = new TutorModel();

        $tutor = $tutorModel->getTutorById($id);

        if (!$tutor) {
            $_SESSION['flash']['error'] = 'Tutor not found.';
            header('Location: ' . BASE_URL . 'find_tutor.php');
            exit;
        }

        // Pass data to view
        $this->view('student/tutor_profile', ['tutor' => $tutor]);
    }

    public function requestTutor()
    {

        $tutorModel = new TutorModel();
        $studentModel = new StudentModel();

        if (!isset($_GET['id'])) {
            $_SESSION['flash']['error'] = "No tutor selected.";
            header('Location: find_tutor.php');
            exit;
        }

        $tutorId = $_GET['id'];
        $tutor = $tutorModel->getTutorById($tutorId);

        if (!$tutor) {
            $_SESSION['flash']['error'] = "Tutor not found.";
            header('Location: find_tutor.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentId = $_SESSION['user_id'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            $studentModel->createRequest($studentId, $tutorId, $subject, $message);
            $_SESSION['flash']['success'] = "Tutoring request sent successfully.";
            header('Location: view_requests.php');
            exit;
        }

        $this->view('student/request_tutor', ['tutor' => $tutor]);
    }
    public function viewRequests()
    {
        $studentModel = new StudentModel();

        $studentId = $_SESSION['user_id'];
        $requests = $studentModel->getRequestsByStudent($studentId);

        $this->view('student/view_requests', ['requests' => $requests]);
    }
}
