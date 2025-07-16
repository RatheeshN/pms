<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController {
    private $project;

    public function __construct() {
        $this->project = new Project();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        $projects = $this->project->getAllProjects($_SESSION['user_id'], $_SESSION['role']);
        include __DIR__ . '/../views/projects/index.php';
    }

    public function create() {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: /pms/public/projects');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $team_members = $_POST['team_members'] ?? [];
            
            if (empty($name)) {
                $error = 'Project name is required';
            } else {
                $this->project->createProject($name, $description, $team_members);
                header('Location: /pms/public/projects');
                exit;
            }
        }
        $users = $this->project->getAllUsers();
        include __DIR__ . '/../views/projects/create.php';
    }
}
?>