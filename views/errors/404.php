<?php ob_start(); ?>
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <h1>404 - Page Not Found</h1>
        <p>The requested page could not be found.</p>
        <a href="/dashboard" class="btn btn-primary">Back to Dashboard</a>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>