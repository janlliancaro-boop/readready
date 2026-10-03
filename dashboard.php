<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/database.php';

if (!is_learner_logged_in()) {
    redirect('/index.php');
}

$database = new Database();
$conn = $database->getConnection();

$learnerId = (int) $_SESSION['learner_id'];
$learnerToken = $_SESSION['learner_token'];

$stmt = $conn->prepare('SELECT * FROM learners WHERE id = ? AND learner_token = ? LIMIT 1');
$stmt->bind_param('is', $learnerId, $learnerToken);
$stmt->execute();
$learnerResult = $stmt->get_result();

if ($learnerResult->num_rows !== 1) {
    session_unset();
    session_destroy();
    redirect('/index.php');
}

$learner = $learnerResult->fetch_assoc();
$stmt->close();

$quote = 'Every new word is a small adventure!';
$progressStmt = $conn->prepare('SELECT * FROM learner_progress WHERE learner_id = ? ORDER BY updated_at DESC LIMIT 1');
$progressStmt->bind_param('i', $learnerId);
$progressStmt->execute();
$progressResult = $progressStmt->get_result();
$progress = $progressResult->num_rows > 0 ? $progressResult->fetch_assoc() : ['progress_percent' => 0, 'lessons_completed' => 0, 'activities_completed' => 0, 'words_learned' => 0];
$progressStmt->close();

$badgesStmt = $conn->prepare('SELECT COUNT(*) AS total FROM learner_badges WHERE learner_id = ?');
$badgesStmt->bind_param('i', $learnerId);
$badgesStmt->execute();
$badgesCount = $badgesStmt->get_result()->fetch_assoc()['total'] ?? 0;
$badgesStmt->close();

$activityStmt = $conn->prepare('SELECT COUNT(*) AS total FROM learner_activities WHERE learner_id = ?');
$activityStmt->bind_param('i', $learnerId);
$activityStmt->execute();
$activityCount = $activityStmt->get_result()->fetch_assoc()['total'] ?? 0;
$activityStmt->close();

$wordCount = (int) ($progress['words_learned'] ?? 0);
$progressPercent = (int) ($progress['progress_percent'] ?? 0);
$stats = [
    'level' => $learner['current_level'] ?? 'Beginner',
    'stars' => (int) ($learner['stars'] ?? 0),
    'coins' => (int) ($learner['coins'] ?? 0),
    'badges' => (int) $badgesCount,
    'progress' => $progressPercent,
    'activities' => (int) ($progress['activities_completed'] ?? 0),
];

$cards = [
    ['Dictionary', 'Explore new words', '📚', APP_BASE_URL . '/modules/dictionary/index.php'],
    ['Alphabet Learning', 'Letters and sounds', '🔤', APP_BASE_URL . '/modules/nursery/index.php'],
    ['Shape Recognition', 'Learn shapes', '🔺', APP_BASE_URL . '/modules/nursery/index.php'],
    ['Number Recognition', 'Count from 1 to 100', '🔢', APP_BASE_URL . '/modules/nursery/index.php'],
    ['Math Adventure', 'Add and subtract', '➕', APP_BASE_URL . '/modules/nursery/index.php'],
    ['Word Learning', 'Sight words', '📝', APP_BASE_URL . '/modules/nursery/index.php'],
    ['Spelling Bee', 'Hear and type', '🐝', APP_BASE_URL . '/modules/quiz/index.php'],
    ['Word Puzzle', 'Unscramble and match', '🧩', APP_BASE_URL . '/modules/quiz/index.php'],
    ['Interactive Quiz', 'Fun check-ins', '🎯', APP_BASE_URL . '/modules/quiz/index.php'],
    ['Achievements', 'Earn badges', '🏆', APP_BASE_URL . '/modules/rewards/index.php'],
];

$recentActivities = $conn->query('SELECT activity_name, created_at FROM learner_activities WHERE learner_id = ' . (int) $learnerId . ' ORDER BY created_at DESC LIMIT 4');
$badgesList = $conn->query('SELECT b.name, b.icon FROM learner_badges lb JOIN badges b ON b.id = lb.badge_id WHERE lb.learner_id = ' . (int) $learnerId . ' ORDER BY lb.created_at DESC LIMIT 5');

require __DIR__ . '/includes/header.php';
?>

<section class="dashboard-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="avatar-display-large"><?php echo e($learner['avatar'] ?? '🙂'); ?></div>
                    <div>
                        <p class="mb-1 text-uppercase small text-primary fw-bold">Welcome back</p>
                        <h1 class="display-5 fw-bold mb-0"><?php echo e($learner['nickname']); ?></h1>
                    </div>
                </div>
                <p class="lead text-muted"><?php echo e($quote); ?></p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?php echo APP_BASE_URL; ?>/modules/dictionary/index.php" class="btn btn-primary btn-lg">Dictionary</a>
                    <a href="<?php echo APP_BASE_URL; ?>/modules/nursery/index.php" class="btn btn-success btn-lg">Nursery</a>
                    <a href="<?php echo APP_BASE_URL; ?>/modules/quiz/index.php" class="btn btn-warning btn-lg text-dark">Quiz</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="stat-card primary">
                            <span class="stat-label">Current Level</span>
                            <h3><?php echo e($stats['level']); ?></h3>
                            <div class="progress"><div class="progress-bar" style="width: <?php echo (int)$stats['progress']; ?>%"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card success">
                            <span class="stat-label">Stars</span>
                            <h3><?php echo e($stats['stars']); ?></h3>
                            <div class="progress"><div class="progress-bar" style="width: <?php echo min(100, $stats['stars']); ?>%"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card warning">
                            <span class="stat-label">Coins</span>
                            <h3><?php echo e($stats['coins']); ?></h3>
                            <div class="progress"><div class="progress-bar" style="width: <?php echo min(100, $stats['coins']); ?>%"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card purple">
                            <span class="stat-label">Progress</span>
                            <h3><?php echo e($stats['progress']); ?>%</h3>
                            <div class="progress"><div class="progress-bar" style="width: <?php echo e($stats['progress']); ?>%"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card soft-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="h4 mb-0">Quick Access</h2>
                            <span class="badge bg-light text-dark">Today</span>
                        </div>
                        <div class="row g-3">
                            <?php foreach ($cards as $card): ?>
                                <div class="col-md-6 col-xl-4">
                                    <a href="<?php echo $card[3]; ?>" class="quick-card h-100">
                                        <div class="icon-box"><?php echo $card[2]; ?></div>
                                        <h5><?php echo e($card[0]); ?></h5>
                                        <small><?php echo e($card[1]); ?></small>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card soft-card h-100">
                    <div class="card-body">
                        <h2 class="h4 mb-4">Badges earned</h2>
                        <div class="badge-stack">
                            <?php if ($badgesList && $badgesList->num_rows > 0): while ($badge = $badgesList->fetch_assoc()): ?>
                                <div class="badge-item">
                                    <span class="badge-icon"><?php echo e($badge['icon'] ?? '🏅'); ?></span>
                                    <div>
                                        <strong><?php echo e($badge['name']); ?></strong>
                                        <small class="d-block text-muted">Unlocked</small>
                                    </div>
                                </div>
                            <?php endwhile; else: ?>
                                <div class="text-muted">No badges earned yet.</div>
                            <?php endif; ?>
                        </div>

                        <h2 class="h5 mt-4 mb-3">Learning stats</h2>
                        <ul class="list-unstyled stats-list">
                            <li><span>Progress</span><strong><?php echo e($stats['progress']); ?>%</strong></li>
                            <li><span>Badges</span><strong><?php echo e($stats['badges']); ?></strong></li>
                            <li><span>Words learned</span><strong><?php echo e($wordCount); ?></strong></li>
                            <li><span>Activities done</span><strong><?php echo e($stats['activities']); ?></strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const learner = {
    id: <?php echo (int) $learner['id']; ?>,
    token: '<?php echo e($learnerToken); ?>',
    nickname: '<?php echo e($learner['nickname']); ?>',
    avatar: '<?php echo e($learner['avatar'] ?? '🙂'); ?>'
};
localStorage.setItem('readready_learner', JSON.stringify(learner));
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
