<?php
require_once __DIR__ . '/../config/database.php';

class Task {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getTasksByUser($user_id, $role) {
        $query = $role === 'admin' 
            ? "SELECT t.*, p.name AS project_name FROM tasks t JOIN projects p ON t.project_id = p.id"
            : "SELECT t.*, p.name AS project_name FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.assigned_to = :user_id";
        $stmt = $this->db->prepare($query);
        if ($role !== 'admin') {
            $stmt->bindParam(':user_id', $user_id);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask($title, $description, $due_date, $priority, $status, $project_id, $assigned_to, $attachment) {
        $query = "INSERT INTO tasks (title, description, due_date, priority, status, project_id, assigned_to, attachment) 
                  VALUES (:title, :description, :due_date, :priority, :status, :project_id, :assigned_to, :attachment)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':project_id', $project_id);
        $stmt->bindParam(':assigned_to', $assigned_to);
        $stmt->bindParam(':attachment', $attachment);
        $stmt->execute();
    }
}
?>