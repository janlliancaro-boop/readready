<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/database.php';

if (!is_admin_logged_in()) {
    redirect('/admin/login.php');
}

$conn = (new Database())->getConnection();
$rows = $conn->query('SELECT * FROM admins LIMIT 5');

require __DIR__ . '/../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-danger fw-bold mb-1">Admin</p>
            <h1 class="mb-0">Administrator Details</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/admin/dashboard.php" class="btn btn-outline-danger">Back</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $rows->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo e($row['id']); ?></td>
                        <td><?php echo e($row['username']); ?></td>
                        <td><?php echo e($row['role']); ?></td>
                        <td><?php echo e($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
