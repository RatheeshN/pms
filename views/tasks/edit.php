<?php $content = ob_get_clean(); include __DIR__ . '/../layouts/main.php'; ?>
<div class="card">
    <div class="card-body">
        <h2>Edit Task</h2>
        <form method="POST" action="/pms/public/tasks/update/<?php echo $task['id']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($task['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="project_id" class="form-label">Project</label>
                <select class="form-control" id="project_id" name="project_id">
                    <option value="">None</option>
                    <?php
                    $projectModel = new Project();
                    $projects = $projectModel->getAllProjects($_SESSION['user_id'], $_SESSION['role']);
                    foreach ($projects as $p) {
                        $selected = $task['project_id'] == $p['id'] ? 'selected' : '';
                        echo "<option value='{$p['id']}' $selected>" . htmlspecialchars($p['name']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/pms/public/tasks" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>