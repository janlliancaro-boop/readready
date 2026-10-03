<?php
require __DIR__ . '/../../includes/config.php';
$active = 'dictionary';
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
                    <form class="row g-2 mb-4">
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-lg" placeholder="Search for a word..." value="apple">
                        </div>
                        <div class="col-md-3 d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">Search</button>
                        </div>
                    </form>

                    <div class="dictionary-result">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="word-image small">🍎</div>
                            <div>
                                <h4 class="mb-1">Apple</h4>
                                <small class="text-muted">/ˈæp.əl/</small>
                            </div>
                        </div>
                        <p><strong>Definition:</strong> A round fruit with a crisp texture and sweet taste.</p>
                        <p><strong>Example:</strong> "The apple fell from the tree and rolled into the grass."</p>
                        <button class="btn btn-success" type="button">🔊 Listen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h2 class="h3 mb-3">Picture Dictionary</h2>
        <div class="row g-3">
            <?php
            $categories = [
                ['Animals', '🐶', 'Dog'],
                ['Fruits', '🍇', 'Grapes'],
                ['Vegetables', '🥕', 'Carrot'],
                ['Colors', '🎨', 'Red'],
                ['Body Parts', '👀', 'Eyes'],
                ['School Objects', '📚', 'Book'],
                ['Transportation', '🚗', 'Car'],
            ];
            foreach ($categories as $item): ?>
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <div class="card category-card h-100 text-center">
                        <div class="card-body">
                            <div class="category-icon"><?php echo $item[1]; ?></div>
                            <h5><?php echo $item[0]; ?></h5>
                            <p class="mb-0"><?php echo $item[2]; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
