<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/database.php';

$database = new Database();
$conn = $database->getConnection();

$active = 'admin';

$learners = $conn->query('SELECT COUNT(*) AS total FROM learners');
$words = $conn->query('SELECT COUNT(*) AS total FROM dictionary_words');
$quizzes = $conn->query('SELECT COUNT(*) AS total FROM quizzes');
$badges = $conn->query('SELECT COUNT(*) AS total FROM achievements');

$learnerCount = $learners ? ($learners->fetch_assoc()['total'] ?? 0) : 0;
$wordCount = $words ? ($words->fetch_assoc()['total'] ?? 0) : 0;
$quizCount = $quizzes ? ($quizzes->fetch_assoc()['total'] ?? 0) : 0;
$badgeCount = $badges ? ($badges->fetch_assoc()['total'] ?? 0) : 0;

require __DIR__ . '/../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-danger fw-bold mb-1">Admin Panel</p>
            <h1 class="mb-0">ReadReady Control Center</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-danger">Learner View</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card primary">
                <span class="stat-label">Total Learners</span>
                <h3><?php echo e($learnerCount); ?></h3>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card success">
                <span class="stat-label">Words</span>
                <h3><?php echo e($wordCount); ?></h3>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card warning">
                <span class="stat-label">Quizzes</span>
                <h3><?php echo e($quizCount); ?></h3>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card purple">
                <span class="stat-label">Badges</span>
                <h3><?php echo e($badgeCount); ?></h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5 mb-3">Quick Content Management</h3>
                    <form class="row g-3">
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="Word title">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="Category">
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" rows="3" placeholder="Definition and example sentence"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-danger" type="submit">Save Word</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5 mb-3">Reports</h3>
                    <ul class="list-unstyled stats-list">
                        <li><span>Most played activities</span><strong>Alphabet</strong></li>
                        <li><span>Quiz results</span><strong>88% avg</strong></li>
                        <li><span>Badge statistics</span><strong>6 earned</strong></li>
                        <li><span>New learners</span><strong>12 this week</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
