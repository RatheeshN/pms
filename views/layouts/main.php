<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/pms/public/dashboard">Project Management</a>
            <div class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="/pms/public/projects">Projects</a>
                    <a class="nav-link" href="/pms/public/tasks">Tasks</a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a class="nav-link" href="/pms/public/projects/create">Create Project</a>
                    <?php endif; ?>
                    <a class="nav-link" href="/pms/public/logout">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="/pms/public/auth/login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-10">
                <?php echo $content; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>