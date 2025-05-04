<?php
require './app/models/AuthModel.php';
class AuthController extends Controller
{

    private $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validation
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $_SESSION['flash']['error'] = 'All fields are required.';
                $this->view('auth/signup', ['hideLayout' => true]);
                return;
            }

            if ($password !== $confirm_password) {
                $_SESSION['flash']['error'] = 'Passwords do not match.';
                $this->view('auth/signup', ['hideLayout' => true]);
                return;
            }

            if ($this->authModel->isEmailTaken($email)) {
                $_SESSION['flash']['error'] = 'Email is already in use.';
                $this->view('auth/signup', ['hideLayout' => true]);
                return;
            }

            // Hash password and create user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'student';
            $this->authModel->createUser($name, $email, $hashed_password, $role);

            // Set a success message and redirect to login page
            $_SESSION['flash']['success'] = 'Signup successful. You can now login.';
            header("Location: " . BASE_URL . "login");
            exit();
        }

        $this->view('auth/signup', ['hideLayout' => true]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Validation
            if (empty($email) || empty($password)) {
                $_SESSION['flash']['error'] = 'Both email and password are required.';
                $this->view('auth/login', ['hideLayout' => true]);
                return;
            }


            $user = $this->validateLogin($email, $password);

            if (!$user) {
                $_SESSION['flash']['error'] = 'Incorrect email or password!';
                $this->view('auth/login', ['hideLayout' => true]);
            } else {
                // User is authenticated, set session data
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];

                // Redirect to the dashboard or wherever after login

                if ($_SESSION['role'] == 'admin') {
                    header("Location: " . BASE_URL . "admin_dashboard.php");
                } else {
                    header("Location: " . BASE_URL . "student_dashboard.php");

                }
            }
            exit();
        }

        $this->view('auth/login', ['hideLayout' => true]);
    }

    private function validateLogin($email, $password)
    {
        // Check if the user exists and the password is correct
        $user = $this->authModel->getUserByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }
        return $user;
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']);
    }

    public static function isAdmin()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
    }

    public static function isStudent()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'student';
    }

    public function logoutUser(){
        session_destroy();
        header('location:'.BASE_URL.'login.php');
    }

}
