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
            <a class="navbar-brand" href="/dashboard">Project Management</a>
            <div class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="/projects">Projects</a>
                    <a class="nav-link" href="/tasks">Tasks</a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a class="nav-link" href="/projects/create">Create Project</a>
                    <?php endif; ?>
                    <a class="nav-link" href="/logout">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="/auth/login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php
        if (isset($content) && file_exists($content)) {
            include $content;
        } elseif (basename($_SERVER['PHP_SELF']) === 'index.php' && isset($_GET['route']) && $_GET['route'] === 'auth/login') {
            include __DIR__ . '/auth/login.php';
        } else {
            include __DIR__ . '/dashboard/index.php';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>