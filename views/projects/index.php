<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/main.php'; ?>
<h2>Projects</h2>
<?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="/pms/public/projects/create" class="btn btn-primary mb-3">Create Project</a>
<?php endif; ?>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $project): ?>
            <tr>
                <td><?php echo htmlspecialchars($project['name']); ?></td>
                <td><?php echo htmlspecialchars($project['description']); ?></td>
                <td>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="/pms/public/projects/edit/<?php echo $project['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/pms/public/projects/delete/<?php echo $project['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>