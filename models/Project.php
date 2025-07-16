<?php
require_once __DIR__ . '/../config/database.php';

class Project {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllProjects($user_id, $role) {
        $query = $role === 'admin' 
            ? "SELECT * FROM projects"
            : "SELECT p.* FROM projects p JOIN project_members pm ON p.id = pm.project_id WHERE pm.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        if ($role !== 'admin') {
            $stmt->bindParam(':user_id', $user_id);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProject($name, $description, $team_members) {
        $this->db->beginTransaction();
        $query = "INSERT INTO projects (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
        $project_id = $this->db->lastInsertId();

        foreach ($team_members as $user_id) {
            $query = "INSERT INTO project_members (project_id, user_id) VALUES (:project_id, :user_id)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':project_id', $project_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }
        $this->db->commit();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users WHERE role = 'member'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>