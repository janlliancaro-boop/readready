<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/database.php';

if (!is_admin_logged_in()) {
    redirect('/admin/login.php');
}

$conn = (new Database())->getConnection();
$learners = $conn->query('SELECT id, learner_token, nickname, avatar, current_level, stars, coins, total_badges, total_achievements FROM learners ORDER BY created_at DESC');

require __DIR__ . '/../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-danger fw-bold mb-1">Learner Management</p>
            <h1 class="mb-0">Learner Records</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/admin/dashboard.php" class="btn btn-outline-danger">Back to Dashboard</a>
    </div>

    <?php if ($learners && $learners->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Learner ID</th>
                        <th>Nickname</th>
                        <th>Avatar</th>
                        <th>Progress</th>
                        <th>Badges</th>
                        <th>Rewards</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $learners->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo e($row['id']); ?></td>
                            <td><?php echo e($row['nickname']); ?></td>
                            <td><?php echo e($row['avatar'] ?? '🙂'); ?></td>
                            <td><?php echo e($row['current_level'] ?? 'Beginner'); ?></td>
                            <td><?php echo e($row['total_badges'] ?? 0); ?></td>
                            <td><?php echo e($row['stars'] ?? 0); ?> stars</td>
                            <td><?php echo e($row['total_achievements'] ?? 0); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No learner records available yet.</div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
