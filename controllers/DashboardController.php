<?php
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/Task.php';

class DashboardController {
    private $project;
    private $task;

    public function __construct() {
        $this->project = new Project();
        $this->task = new Task();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /pms/public/auth/login');
            exit;
        }

        $role = $_SESSION['role'];
        $user_id = $_SESSION['user_id'];

        if ($role === 'admin') {
            $projects = $this->project->getAllProjects($user_id, $role);
            $tasks = $this->task->getTasksByUser($user_id, $role);
            $workload = count($tasks);
            //echo '<pre>'; var_dump($projects, $tasks); echo '</pre>'; 
        } else {
            $projects = $this->project->getAllProjects($user_id, $role);
            $tasks = $this->task->getTasksByUser($user_id, $role);
            //echo '<pre>'; var_dump($projects, $tasks); echo '</pre>';
        }

        include __DIR__ . '/../views/dashboard/index.php';
    }
}
?>