<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/Project.php';

class TaskController {
    private $task;
    private $project;

    public function __construct() {
        $this->task = new Task();
        $this->project = new Project();
    }

    public function index() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        $tasks = $this->task->getTasksByUser($_SESSION['user_id'], $_SESSION['role']);
        $projects = $this->project->getAllProjects($_SESSION['user_id'], $_SESSION['role']);
        // Pass $tasks and $projects to the view
        include __DIR__ . '/../views/tasks/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $due_date = filter_input(INPUT_POST, 'due_date', FILTER_SANITIZE_SPECIAL_CHARS);
            $priority = filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_SPECIAL_CHARS);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
            $project_id = filter_input(INPUT_POST, 'project_id', FILTER_SANITIZE_NUMBER_INT);
            $assigned_to = filter_input(INPUT_POST, 'assigned_to', FILTER_SANITIZE_NUMBER_INT);

            if (empty($title) || empty($due_date) || empty($priority) || empty($status)) {
                $error = 'Required fields are missing';
            } else {
                if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['application/pdf', 'application/msword', 'image/jpeg'];
                    $max_size = 5 * 1024 * 1024; // 5MB
                    if (in_array($_FILES['attachment']['type'], $allowed_types) && $_FILES['attachment']['size'] <= $max_size) {
                        $filename = uniqid() . '_' . $_FILES['attachment']['name'];
                        move_uploaded_file($_FILES['attachment']['tmp_name'], __DIR__ . '/../public/uploads/' . $filename);
                    } else {
                        $error = 'Invalid file type or size';
                    }
                }
                if (!isset($error)) {
                    $this->task->createTask($title, $description, $due_date, $priority, $status, $project_id, $assigned_to, $filename ?? null);
                }
            }
        }
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        $projects = $this->project->getAllProjects($_SESSION['user_id'], $_SESSION['role']);
        $users = $this->project->getAllUsers();
        // Pass $projects and $users to the view
        include __DIR__ . '/../views/tasks/create.php';
    }

    public function edit($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        $task = $this->task->getTaskById($id);
        if (!$task || ($task['assigned_to'] != $_SESSION['user_id'] && $_SESSION['role'] !== 'admin')) {
            header('Location: /pms/public/tasks');
            exit;
        }
        
        include __DIR__ . '/../views/tasks/edit.php';
    }

    public function update($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $due_date = $_POST['due_date'] ?? '';
            $project_id = $_POST['project_id'] ?? null;
            $this->task->updateTask($id, $title, $description, $due_date, $project_id);
            header('Location: /pms/public/tasks');
            exit;
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }
        $task = $this->task->getTaskById($id);
        if ($task && ($task['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] === 'admin')) {
            $this->task->deleteTask($id);
        }
        header('Location: /pms/public/tasks');
        exit;
    }
}
?>