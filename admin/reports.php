<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/database.php';

if (!is_admin_logged_in()) {
    redirect('/admin/login.php');
}

$conn = (new Database())->getConnection();
$activityRows = $conn->query('SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 20');

require __DIR__ . '/../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-danger fw-bold mb-1">Reports</p>
            <h1 class="mb-0">Learner Performance Reports</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/admin/dashboard.php" class="btn btn-outline-danger">Back to Dashboard</a>
    </div>

    <?php if ($activityRows && $activityRows->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Type</th>
                        <th>Session</th>
                        <th>Recorded</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $activityRows->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo e($row['activity_name']); ?></td>
                            <td><?php echo e($row['activity_type']); ?></td>
                            <td><?php echo e($row['session_data'] ?? ''); ?></td>
                            <td><?php echo e($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No learner activity available yet.</div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
