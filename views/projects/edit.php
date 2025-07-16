<?php $content = ob_get_clean(); include __DIR__ . '/../layouts/main.php'; ?>
<div class="card">
    <div class="card-body">
        <h2>Edit Project</h2>
        <form method="POST" action="/pms/public/projects/update/<?php echo $project['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($project['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/pms/public/projects" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>