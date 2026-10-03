<?php
require __DIR__ . '/../../includes/config.php';
require __DIR__ . '/../../includes/database.php';

if (!is_learner_logged_in()) {
    redirect('/index.php');
}

$conn = (new Database())->getConnection();
$lessons = $conn->query('SELECT * FROM lessons ORDER BY id ASC');

require __DIR__ . '/../../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-success fw-bold mb-1">Nursery Learning</p>
            <h1 class="mb-0">Alphabet, Shapes, Numbers & More</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-success">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <?php while ($lesson = $lessons->fetch_assoc()): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card soft-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="h5 mb-0"><?php echo e($lesson['title']); ?></h3>
                            <span class="badge bg-success"><?php echo e($lesson['difficulty']); ?></span>
                        </div>
                        <p class="text-muted"><?php echo e($lesson['description']); ?></p>
                        <div class="lesson-box">
                            <strong>Topic:</strong> <?php echo e($lesson['lesson_type']); ?><br>
                            <small class="text-muted">Interactive learning activity</small>
                        </div>
                        <button class="btn btn-success mt-3 w-100" type="button">Play Activity</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
