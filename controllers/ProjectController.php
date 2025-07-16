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
            $name = trim(filter_input(INPUT_POST, 'name', FILTER_DEFAULT));
            $description = trim(filter_input(INPUT_POST, 'description', FILTER_DEFAULT));
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
    public function edit($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        $project = $this->project->getProjectById($id);
        
        include __DIR__ . '/../views/projects/edit.php';
    }

    public function update($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $this->project->updateProject($id, $name, $description);
            header('Location: /pms/public/projects');
            exit;
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        $project = $this->project->getProjectById($id);
        if ($project && ($project['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] === 'admin')) {
            $this->project->deleteProject($id);
        }
        header('Location: /pms/public/projects');
        exit;
    }
}
?>