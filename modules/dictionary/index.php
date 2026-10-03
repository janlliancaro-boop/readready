<?php
require __DIR__ . '/../../includes/config.php';
require __DIR__ . '/../../includes/database.php';

if (!is_learner_logged_in()) {
    redirect('/index.php');
}

$database = new Database();
$conn = $database->getConnection();
$learnerId = (int) $_SESSION['learner_id'];

$categories = $conn->query('SELECT * FROM dictionary_categories ORDER BY display_order ASC');
$words = $conn->query('SELECT dw.*, dc.name AS category_name FROM dictionary_words dw LEFT JOIN dictionary_categories dc ON dc.id = dw.category_id ORDER BY dw.created_at DESC LIMIT 12');

$search = sanitize_text($_GET['search'] ?? '');
if ($search !== '') {
    $searchStatement = $conn->prepare('SELECT dw.*, dc.name AS category_name FROM dictionary_words dw LEFT JOIN dictionary_categories dc ON dc.id = dw.category_id WHERE dw.word LIKE ? OR dw.definition LIKE ? ORDER BY dw.word ASC LIMIT 10');
    $like = '%' . $search . '%';
    $searchStatement->bind_param('ss', $like, $like);
    $searchStatement->execute();
    $words = $searchStatement->get_result();
    $searchStatement->close();
}

require __DIR__ . '/../../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-primary fw-bold mb-1">Dictionary Module</p>
            <h1 class="mb-0">Word Explorer</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-primary">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5 mb-3">Word of the Day</h3>
                    <div class="word-hero">
                        <div class="word-image">🌞</div>
                        <h4>Sun</h4>
                        <p class="text-muted mb-2">/sʌn/</p>
                        <button class="btn btn-sm btn-primary" type="button">🔊 Play Pronunciation</button>
                    </div>
                    <p class="mt-3 mb-0"><strong>Meaning:</strong> The star that gives us light and warmth.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5 mb-3">Search Dictionary</h3>
                    <form class="row g-2 mb-4" method="get" action="<?php echo APP_BASE_URL; ?>/modules/dictionary/index.php">
                        <div class="col-md-9">
                            <input type="text" name="search" class="form-control form-control-lg" value="<?php echo e($search); ?>" placeholder="Search for a word...">
                        </div>
                        <div class="col-md-3 d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">Search</button>
                        </div>
                    </form>

                    <?php if ($words && $words->num_rows > 0): ?>
                        <?php while ($word = $words->fetch_assoc()): ?>
                            <div class="dictionary-result mb-3">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="word-image small"><?php echo e($word['image_url'] ?? '📘'); ?></div>
                                    <div>
                                        <h4 class="mb-1"><?php echo e($word['word']); ?></h4>
                                        <small class="text-muted"><?php echo e($word['category_name'] ?? 'General'); ?></small>
                                    </div>
                                </div>
                                <p><strong>Definition:</strong> <?php echo e($word['definition']); ?></p>
                                <p><strong>Example:</strong> <?php echo e($word['example_sentence'] ?? 'A fun example sentence.'); ?></p>
                                <button class="btn btn-success" type="button">🔊 Listen</button>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="alert alert-info">No dictionary words match your search.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h2 class="h3 mb-3">Picture Dictionary</h2>
        <div class="row g-3">
            <?php while ($category = $categories->fetch_assoc()): ?>
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <div class="card category-card h-100 text-center">
                        <div class="card-body">
                            <div class="category-icon"><?php echo e($category['icon'] ?? '📘'); ?></div>
                            <h5><?php echo e($category['name']); ?></h5>
                            <p class="mb-0"><?php echo e($category['description'] ?? 'Learning category'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
