<?php
require __DIR__ . '/../../includes/config.php';
$active = 'quiz';
require __DIR__ . '/../../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-warning fw-bold mb-1">Assessment Module</p>
            <h1 class="mb-0">Fun Challenges</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-warning text-dark">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Spelling Bee</h3>
                    <p class="lead">Listen and type the correct spelling.</p>
                    <button class="btn btn-primary mb-3" type="button">🔊 Play Sound</button>
                    <input type="text" class="form-control mb-3" placeholder="Type the spelling here...">
                    <button class="btn btn-success" type="button">Check Answer</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Word Puzzle</h3>
                    <div class="puzzle-box">A P L E</div>
                    <p class="mt-3">Unscramble the letters to build the word.</p>
                    <button class="btn btn-info text-white" type="button">Check Word</button>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card soft-card">
                <div class="card-body">
                    <h3 class="h5 mb-4">Interactive Quiz</h3>
                    <div class="quiz-example">
                        <p class="fw-bold">1. Which picture is a circle?</p>
                        <div class="row g-2 mt-3">
                            <div class="col-md-3"><button class="btn btn-outline-primary w-100">🔵</button></div>
                            <div class="col-md-3"><button class="btn btn-outline-primary w-100">🟥</button></div>
                            <div class="col-md-3"><button class="btn btn-outline-primary w-100">📐</button></div>
                            <div class="col-md-3"><button class="btn btn-outline-primary w-100">✅</button></div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <span class="badge bg-secondary">Multiple Choice</span>
                        <span class="badge bg-secondary">True / False</span>
                        <span class="badge bg-secondary">Image Identification</span>
                        <span class="badge bg-secondary">Matching</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
