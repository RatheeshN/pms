<?php $content = ob_get_clean(); include __DIR__ . '/../layouts/main.php'; ?>
<h2>Dashboard</h2>
<?php
$projects = $projects ?? [];
$tasks = $tasks ?? [];
$workload = $workload ?? 0;
?>
<?php if ($_SESSION['role'] === 'admin'): ?>
    <h3>Projects Overview</h3>
    <?php if (empty($projects)): ?>
        <p>No projects found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($projects as $project): ?>
                <li><?php echo htmlspecialchars($project['name'] ?? 'Unnamed'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <h3>Tasks Overview</h3>
    <?php if (empty($tasks)): ?>
        <p>No tasks found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li><?php echo htmlspecialchars($task['title'] ?? 'Untitled'); ?> (Due: <?php echo $task['due_date'] ?? 'N/A'; ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <h3>User Workload</h3>
    <p>Total Tasks: <?php echo $workload; ?></p>
<?php else: ?>
    <h3>Assigned Tasks</h3>
    <?php if (empty($tasks)): ?>
        <p>No tasks assigned.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li><?php echo htmlspecialchars($task['title'] ?? 'Untitled'); ?> (Project: <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>, Due: <?php echo $task['due_date'] ?? 'N/A'; ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>