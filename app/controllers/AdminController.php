<?php

class AdminController extends Controller
{
    private $tutorModel;

    public function __construct()
    {
        $this->tutorModel = new TutorModel();
    }

    public function index()
    {
        $tutors = $this->tutorModel->getAllTutors();
        $requests = $this->tutorModel->getAllRequests();
        $this->view('admin/dashboard', ['tutors' => $tutors,'requests' => $requests]);
    }

    public function addTutor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $subject = $_POST['subject'];
            $bio = $_POST['bio'];
            $email = $_POST['email'];

            if ($this->tutorModel->isEmailTaken($email)) {
                $_SESSION['flash']['error'] = 'Email is already in use.';
                $this->view('admin/add_tutor');
                return;
            }

            // Handle image upload
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('tutor_', true) . '.' . $ext;
                $uploadPath = 'uploads/' . $imageName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $imagePath = $imageName;
                }
            }

            $availability = [];
            $hasAtLeastOneDay = false;
            foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
                $start = $_POST[$day . '_start'];
                $end = $_POST[$day . '_end'];
                $availability[$day] = ['start' => $start, 'end' => $end];

                if (!empty($start) && !empty($end)) {
                    $hasAtLeastOneDay = true;
                }
            }

            if (!$hasAtLeastOneDay) {
                $_SESSION['flash']['error'] = 'Please provide availability for at least one day.';
                $this->view('admin/add_tutor');
                return;
            }

            $this->tutorModel->createTutor($name, $subject, $bio, $email, $imagePath, $availability);

            $_SESSION['flash']['success'] = "Tutor added successfully.";
            header('Location: ' . BASE_URL . 'add_tutor.php');
            exit;
        }

        $this->view('admin/add_tutor');
    }

    public function editTutor($id)
    {
        $tutor = $this->tutorModel->getTutorById($id);
        if (!$tutor) {
            $_SESSION['flash']['error'] = 'Tutor not found.';
            header('Location: ' . BASE_URL . 'admin_dashboard.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $subject = $_POST['subject'];
            $bio = $_POST['bio'];
            $email = $_POST['email'];

            $availability = [];
            $hasAvailability = false;
            foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
                $start = $_POST[$day . '_start'];
                $end = $_POST[$day . '_end'];
                $availability[$day] = ['start' => $start, 'end' => $end];
                if (!empty($start) || !empty($end)) {
                    $hasAvailability = true;
                }
            }

            if (!$hasAvailability) {
                $_SESSION['flash']['error'] = 'Please provide availability for at least one day.';
                $this->view('admin/edit_tutor', ['tutor' => $tutor]);
                return;
            }

            $imagePath = $tutor['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('tutor_', true) . '.' . $ext;
                $uploadPath = 'uploads/' . $imageName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $imagePath = $imageName;
                }
            }

            $this->tutorModel->updateTutor($id, $name, $subject, $bio, $email, $imagePath, $availability);
            $_SESSION['flash']['success'] = 'Tutor updated successfully.';
            header('Location: ' . BASE_URL . 'admin_dashboard.php');
            exit;
        }

        $this->view('admin/edit_tutor', ['tutor' => $tutor]);
    }

    public function deleteTutor()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['flash']['error'] = "Invalid tutor ID.";
            header('Location: ' . BASE_URL . 'admin_dashboard.php');
            exit;
        }

        $id = (int) $_GET['id'];

        $tutor = $this->tutorModel->getTutorById($id);
        if (!$tutor) {
            $_SESSION['flash']['error'] = "Tutor not found.";
            header('Location: ' . BASE_URL . 'admin_dashboard.php');
            exit;
        }

        $this->tutorModel->deleteTutor($id);

        $_SESSION['flash']['success'] = "Tutor deleted successfully.";
        header('Location: ' . BASE_URL . 'admin_dashboard.php');
        exit;
    }


}
