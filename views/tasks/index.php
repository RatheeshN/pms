<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/main.php'; ?>
<h2>Tasks</h2>
<?php if ($_SESSION['role'] === 'admin'): ?>
<a href="/pms/public/tasks/create" class="btn btn-primary mb-3">Create Task</a>
<?php endif; ?>
<form method="GET" class="mb-3">
    <div class="row">
        <div class="col">
            <select name="project_id" class="form-control">
                <option value="">All Projects</option>
                <?php foreach ($projects as $project): ?>
                    <option value="<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col">
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="col">
            <select name="priority" class="form-control">
                <option value="">All Priorities</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Project</th>
            <th>Due Date</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Attachment</th>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <th>Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['project_name']); ?></td>
                <td><?php echo $task['due_date']; ?></td>
                <td><?php echo $task['priority']; ?></td>
                <td><?php echo $task['status']; ?></td>
                <td>
                    <?php if ($task['attachment']): ?>
                        <a href="/pms/public/uploads/<?php echo $task['attachment']; ?>" download>Download</a>
                    <?php endif; ?>
                </td>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <td>
                    <a href="/pms/public/tasks/edit/<?php echo $task['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/pms/public/tasks/delete/<?php echo $task['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>