<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/database.php';

if (!isset($_SESSION['readready_nickname'])) {
    header('Location: ' . APP_BASE_URL . '/index.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

$learnerName = $_SESSION['readready_nickname'];
$avatar = $_SESSION['readready_avatar'] ?? '🙂';

$stats = ['lessons' => 8, 'words' => 18, 'quizzes' => 4, 'stars' => 245];
$badges = ['Alphabet Explorer', 'Number Master', 'Vocabulary Hero'];
$activities = ['Dictionary', 'Alphabet Learning', 'Shapes', 'Math Adventure'];

$progress = $conn->query("SELECT COUNT(*) AS total FROM learner_progress WHERE learner_id = 1");
if ($progress && $progress->num_rows > 0) {
    $progressRow = $progress->fetch_assoc();
    $stats['lessons'] = (int)$progressRow['total'] ?: 8;
}

require __DIR__ . '/includes/header.php';
?>

<section class="dashboard-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="avatar-display-large"><?php echo e($avatar); ?></div>
                    <div>
                        <p class="mb-1 text-uppercase small text-primary fw-bold">Welcome back</p>
                        <h1 class="display-5 fw-bold mb-0"><?php echo e($learnerName); ?></h1>
                    </div>
                </div>
                <p class="lead text-muted">Your learning adventure is growing every day. Explore new words, numbers, shapes, and creativity.</p>
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
                            <span class="stat-label">Lessons</span>
                            <h3><?php echo (int)$stats['lessons']; ?></h3>
                            <div class="progress"><div class="progress-bar" style="width: 72%"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card success">
                            <span class="stat-label">Words</span>
                            <h3><?php echo (int)$stats['words']; ?></h3>
                            <div class="progress"><div class="progress-bar" style="width: 80%"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card warning">
                            <span class="stat-label">Quizzes</span>
                            <h3><?php echo (int)$stats['quizzes']; ?></h3>
                            <div class="progress"><div class="progress-bar" style="width: 65%"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card purple">
                            <span class="stat-label">Stars</span>
                            <h3><?php echo (int)$stats['stars']; ?></h3>
                            <div class="progress"><div class="progress-bar" style="width: 88%"></div></div>
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
                            <?php
                            $cards = [
                                ['Dictionary', 'Learn new words', '📚', APP_BASE_URL . '/modules/dictionary/index.php'],
                                ['Alphabet Learning', 'Letters and sounds', '🔤', APP_BASE_URL . '/modules/nursery/index.php'],
                                ['Shape Recognition', 'Find shapes', '🔺', APP_BASE_URL . '/modules/nursery/index.php'],
                                ['Number Recognition', 'Count from 1 to 100', '🔢', APP_BASE_URL . '/modules/nursery/index.php'],
                                ['Math Adventure', 'Add and subtract', '➕', APP_BASE_URL . '/modules/nursery/index.php'],
                                ['Word Learning', 'Sight words', '📝', APP_BASE_URL . '/modules/nursery/index.php'],
                                ['Spelling Bee', 'Type the word', '🐝', APP_BASE_URL . '/modules/quiz/index.php'],
                                ['Word Puzzle', 'Unscramble letters', '🧩', APP_BASE_URL . '/modules/quiz/index.php'],
                                ['Interactive Quiz', 'Fun challenge', '🎯', APP_BASE_URL . '/modules/quiz/index.php'],
                                ['Achievements', 'Earn badges', '🏆', APP_BASE_URL . '/modules/rewards/index.php'],
                            ];
                            foreach ($cards as $card): ?>
                                <div class="col-md-6 col-xl-4">
                                    <a href="<?php echo $card[2] ?? '#'; ?>" class="quick-card h-100">
                                        <div class="icon-box"><?php echo $card[2]; ?></div>
                                        <h5><?php echo $card[0]; ?></h5>
                                        <small><?php echo $card[1]; ?></small>
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
                            <?php foreach ($badges as $badge): ?>
                                <div class="badge-item">
                                    <span class="badge-icon">🏅</span>
                                    <div>
                                        <strong><?php echo e($badge); ?></strong>
                                        <small class="d-block text-muted">Unlocked</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <h2 class="h5 mt-4 mb-3">Learning stats</h2>
                        <ul class="list-unstyled stats-list">
                            <li><span>Accuracy</span><strong>89%</strong></li>
                            <li><span>Streak</span><strong>7 days</strong></li>
                            <li><span>Words learned</span><strong>32</strong></li>
                            <li><span>Activities done</span><strong>18</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
