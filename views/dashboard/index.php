<?php $content = ob_get_clean(); include __DIR__ . '/../layouts/main.php'; ?>
<h2 class="mb-4">Dashboard</h2>
<?php
$projects = $projects ?? [];
$tasks = $tasks ?? [];
$workload = $workload ?? 0;
?>
<div class="row">
<?php if ($_SESSION['role'] === 'admin'): ?>
    <div class="col-md-4 mb-3">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Projects Overview</h5>
            </div>
            <div class="card-body">
                <?php if (empty($projects)): ?>
                    <p class="text-muted">No projects found.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($projects as $project): ?>
                            <li class="list-group-item"><?php echo htmlspecialchars($project['name'] ?? 'Unnamed'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Tasks Overview</h5>
            </div>
            <div class="card-body">
                <?php if (empty($tasks)): ?>
                    <p class="text-muted">No tasks found.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($tasks as $task): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($task['title'] ?? 'Untitled'); ?>
                                <span class="badge bg-secondary float-end">Due: <?php echo $task['due_date'] ?? 'N/A'; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">User Workload</h5>
            </div>
            <div class="card-body">
                <p class="fs-4 mb-0">Total Tasks: <span class="badge bg-dark"><?php echo $workload; ?></span></p>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Assigned Tasks</h5>
            </div>
            <div class="card-body">
                <?php if (empty($tasks)): ?>
                    <p class="text-muted">No tasks assigned.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($tasks as $task): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($task['title'] ?? 'Untitled'); ?>
                                <br>
                                <small class="text-muted">
                                    Project: <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>,
                                    Due: <?php echo $task['due_date'] ?? 'N/A'; ?>
                                </small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>