<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/database.php';

if (!is_admin_logged_in()) {
    redirect('/admin/login.php');
}

$conn = (new Database())->getConnection();

$learnersCount = (int) ($conn->query('SELECT COUNT(*) AS total FROM learners')->fetch_assoc()['total'] ?? 0);
$dictionaryWordsCount = (int) ($conn->query('SELECT COUNT(*) AS total FROM dictionary_words')->fetch_assoc()['total'] ?? 0);
$lessonsCount = (int) ($conn->query('SELECT COUNT(*) AS total FROM lessons')->fetch_assoc()['total'] ?? 0);
$quizzesCount = (int) ($conn->query('SELECT COUNT(*) AS total FROM quizzes')->fetch_assoc()['total'] ?? 0);
$activitiesCount = (int) ($conn->query('SELECT COUNT(*) AS total FROM activity_logs')->fetch_assoc()['total'] ?? 0);
$badgesCount = (int) ($conn->query('SELECT COUNT(*) AS total FROM badges')->fetch_assoc()['total'] ?? 0);

$recentLogs = $conn->query('SELECT a.activity_name, a.created_at, l.nickname FROM activity_logs a LEFT JOIN learners l ON l.id = a.learner_id ORDER BY a.created_at DESC LIMIT 5');

require __DIR__ . '/../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-danger fw-bold mb-1">Admin Dashboard</p>
            <h1 class="mb-0">ReadReady Control Center</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo APP_BASE_URL; ?>/admin/reports.php" class="btn btn-outline-danger">Reports</a>
            <a href="<?php echo APP_BASE_URL; ?>/admin/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3"><div class="stat-card primary"><span class="stat-label">Total Learners</span><h3><?php echo e($learnersCount); ?></h3></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card success"><span class="stat-label">Dictionary Words</span><h3><?php echo e($dictionaryWordsCount); ?></h3></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card warning"><span class="stat-label">Lessons</span><h3><?php echo e($lessonsCount); ?></h3></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card purple"><span class="stat-label">Quizzes</span><h3><?php echo e($quizzesCount); ?></h3></div></div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-4"><div class="stat-card primary"><span class="stat-label">Activities</span><h3><?php echo e($activitiesCount); ?></h3></div></div>
        <div class="col-md-6 col-xl-4"><div class="stat-card success"><span class="stat-label">Badges</span><h3><?php echo e($badgesCount); ?></h3></div></div>
        <div class="col-md-6 col-xl-4"><div class="stat-card warning"><span class="stat-label">Recent Activity</span><h3><?php echo ($recentLogs && $recentLogs->num_rows > 0) ? e($recentLogs->num_rows) : 0; ?></h3></div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5 mb-3">Recent Activity</h3>
                    <?php if ($recentLogs && $recentLogs->num_rows > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php while ($row = $recentLogs->fetch_assoc()): ?>
                                <li class="list-group-item">
                                    <strong><?php echo e($row['nickname'] ?? 'Guest'); ?></strong> — <?php echo e($row['activity_name']); ?>
                                    <div class="small text-muted"><?php echo e($row['created_at']); ?></div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted mb-0">No learner activity available yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5 mb-3">Quick Links</h3>
                    <div class="d-grid gap-2">
                        <a href="<?php echo APP_BASE_URL; ?>/admin/learners.php" class="btn btn-outline-danger">Learner Management</a>
                        <a href="<?php echo APP_BASE_URL; ?>/admin/badges.php" class="btn btn-outline-danger">Badge Management</a>
                        <a href="<?php echo APP_BASE_URL; ?>/admin/reports.php" class="btn btn-outline-danger">Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
