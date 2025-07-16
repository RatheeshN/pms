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
        session_start();
        $tasks = $this->task->getTasksByUser($_SESSION['user_id'], $_SESSION['role']);
        $projects = $this->project->getAllProjects($_SESSION['user_id'], $_SESSION['role']);
        include __DIR__ . '/../views/tasks/index.php';
    }

    public function create() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $due_date = filter_input(INPUT_POST, 'due_date', FILTER_SANITIZE_STRING);
            $priority = filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
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
                    header('Location: /tasks');
                    exit;
                }
            }
        }
        $projects = $this->project->getAllProjects($_SESSION['user_id'], $_SESSION['role']);
        $users = $this->project->getAllUsers();
        include __DIR__ . '/../views/tasks/create.php';
    }
}
?>