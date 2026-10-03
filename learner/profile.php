<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/database.php';

if (!is_learner_logged_in()) {
    redirect('/index.php');
}

$database = new Database();
$conn = $database->getConnection();
$learnerId = (int) $_SESSION['learner_id'];

$profile = $conn->query('SELECT * FROM learners WHERE id = ' . $learnerId . ' LIMIT 1')->fetch_assoc();
$progress = $conn->query('SELECT * FROM learner_progress WHERE learner_id = ' . $learnerId . ' ORDER BY updated_at DESC LIMIT 1')->fetch_assoc();

require __DIR__ . '/../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-primary fw-bold mb-1">Profile</p>
            <h1 class="mb-0"><?php echo e($profile['nickname']); ?></h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-primary">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card soft-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-display-large mx-auto mb-3"><?php echo e($profile['avatar'] ?? '🙂'); ?></div>
                    <h3><?php echo e($profile['nickname']); ?></h3>
                    <p class="text-muted mb-0"><?php echo e($profile['current_level'] ?? 'Beginner'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <ul class="list-unstyled stats-list">
                        <li><span>Stars</span><strong><?php echo e($profile['stars'] ?? 0); ?></strong></li>
                        <li><span>Coins</span><strong><?php echo e($profile['coins'] ?? 0); ?></strong></li>
                        <li><span>Progress</span><strong><?php echo e($progress['progress_percent'] ?? 0); ?>%</strong></li>
                        <li><span>Activities Completed</span><strong><?php echo e($progress['activities_completed'] ?? 0); ?></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
