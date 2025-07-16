<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));
            $result = $this->authenticate($email, $password);
            if ($result['status']) {
                header('Location: /pms/public/dashboard');
                exit;
            } else {
                $error = $result['message'];
            }
        }
        include __DIR__ . '/../views/auth/login.php';
    }

    private function authenticate($email, $password) {
        if (empty($email) || empty($password)) {
            return ['status' => false, 'message' => 'All fields are required'];
        }
        $user = $this->user->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return ['status' => true];
        }
        return ['status' => false, 'message' => 'Invalid credentials'];
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /pms/public/auth/login');
        exit;
    }
}
?>