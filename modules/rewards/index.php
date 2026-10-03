<?php
require __DIR__ . '/../../includes/config.php';
require __DIR__ . '/../../includes/database.php';

if (!is_learner_logged_in()) {
    redirect('/index.php');
}

$conn = (new Database())->getConnection();
$learnerId = (int) $_SESSION['learner_id'];
$badges = $conn->query('SELECT b.name, b.icon, b.description FROM badges b ORDER BY b.id ASC');
$stars = (int) ($conn->query('SELECT stars FROM learners WHERE id = ' . $learnerId)->fetch_assoc()['stars'] ?? 0);
$coins = (int) ($conn->query('SELECT coins FROM learners WHERE id = ' . $learnerId)->fetch_assoc()['coins'] ?? 0);

require __DIR__ . '/../../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-primary fw-bold mb-1">Rewards</p>
            <h1 class="mb-0">Stars, Coins & Achievements</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-primary">Back to Dashboard</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card primary">
                <span class="stat-label">Stars</span>
                <h3><?php echo e($stars); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card success">
                <span class="stat-label">Coins</span>
                <h3><?php echo e($coins); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card purple">
                <span class="stat-label">Badges</span>
                <h3><?php echo e($badges->num_rows ?? 0); ?></h3>
            </div>
        </div>
    </div>

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
                        <button class="btn btn-primary btn-sm" type="button">Earn by completing tasks</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
