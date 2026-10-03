<?php
require __DIR__ . '/../../includes/config.php';
$active = 'nursery';
require __DIR__ . '/../../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-success fw-bold mb-1">Nursery Learning</p>
            <h1 class="mb-0">Learning Playground</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-success">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-4">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Alphabet Learning</h3>
                    <div class="lesson-box">A is for Apple</div>
                    <p class="mt-3 mb-0">Listen to the sound, trace the letter, and match it with the correct picture.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Shape Recognition</h3>
                    <div class="shape-row">
                        <span class="shape circle">◯</span>
                        <span class="shape square">◼</span>
                        <span class="shape triangle">△</span>
                    </div>
                    <p class="mt-3 mb-0">Circle, square, triangle, rectangle, oval, star, and heart activities.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Number Recognition</h3>
                    <div class="lesson-box number-box">1 2 3 4 5</div>
                    <p class="mt-3 mb-0">Count and match numbers from 1 to 100 with fun activities.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Math Adventure</h3>
                    <div class="lesson-box">3 + 2 = 5</div>
                    <p class="mt-3 mb-0">Addition, subtraction, comparisons, and counting games.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Word Learning</h3>
                    <div class="lesson-box">Sight words: the, is, I, we</div>
                    <p class="mt-3 mb-0">Matching, missing letters, word builders, and sight-word practice.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Adaptive Difficulty</h3>
                    <div class="badge bg-success">Beginner</div>
                    <p class="mt-3 mb-0">The system adapts difficulty as the learner improves and scores higher.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
