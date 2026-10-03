<?php
require __DIR__ . '/../../includes/config.php';
require __DIR__ . '/../../includes/database.php';

if (!is_learner_logged_in()) {
    redirect('/index.php');
}

$conn = (new Database())->getConnection();
$questions = $conn->query('SELECT qq.*, q.title FROM quiz_questions qq JOIN quizzes q ON q.id = qq.quiz_id ORDER BY qq.id ASC LIMIT 6');

require __DIR__ . '/../../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-warning fw-bold mb-1">Assessment & Practice</p>
            <h1 class="mb-0">Interactive Quiz</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-warning text-dark">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <?php while ($question = $questions->fetch_assoc()): ?>
            <div class="col-lg-6">
                <div class="card soft-card h-100">
                    <div class="card-body">
                        <p class="small text-uppercase text-warning fw-bold mb-2"><?php echo e($question['title']); ?></p>
                        <h5><?php echo e($question['question_text']); ?></h5>
                        <div class="mt-3">
                            <ul class="list-unstyled">
                                <li>• <?php echo e($question['option_a']); ?></li>
                                <li>• <?php echo e($question['option_b']); ?></li>
                                <li>• <?php echo e($question['option_c']); ?></li>
                                <li>• <?php echo e($question['option_d']); ?></li>
                            </ul>
                        </div>
                        <button class="btn btn-warning text-dark mt-2" type="button">Submit</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
