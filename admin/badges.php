<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/database.php';

if (!is_admin_logged_in()) {
    redirect('/admin/login.php');
}

$conn = (new Database())->getConnection();
$badges = $conn->query('SELECT * FROM badges ORDER BY created_at DESC');

require __DIR__ . '/../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-danger fw-bold mb-1">Badge Management</p>
            <h1 class="mb-0">Badge Definitions</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/admin/dashboard.php" class="btn btn-outline-danger">Back to Dashboard</a>
    </div>

    <?php if ($badges && $badges->num_rows > 0): ?>
        <div class="row g-3">
            <?php while ($badge = $badges->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card soft-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="badge-medal"><?php echo e($badge['icon'] ?? '🏅'); ?></div>
                                <div>
                                    <h5 class="mb-0"><?php echo e($badge['name']); ?></h5>
                                </div>
                            </div>
                            <p class="mb-2"><?php echo e($badge['description']); ?></p>
                            <small class="text-muted">Requirement: <?php echo e($badge['requirement']); ?></small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No badge definitions available yet.</div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
