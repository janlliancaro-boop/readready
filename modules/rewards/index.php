<?php
require __DIR__ . '/../../includes/config.php';
$active = 'rewards';
require __DIR__ . '/../../includes/header.php';
?>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase small text-purple fw-bold mb-1">Rewards Module</p>
            <h1 class="mb-0">Achievement Center</h1>
        </div>
        <a href="<?php echo APP_BASE_URL; ?>/dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Progress Tracking</h3>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item d-flex justify-content-between"><span>Lessons completed</span><strong>18</strong></li>
                        <li class="list-group-item d-flex justify-content-between"><span>Quiz scores</span><strong>92%</strong></li>
                        <li class="list-group-item d-flex justify-content-between"><span>Words learned</span><strong>32</strong></li>
                        <li class="list-group-item d-flex justify-content-between"><span>Activities completed</span><strong>24</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card soft-card h-100">
                <div class="card-body">
                    <h3 class="h5">Rewards</h3>
                    <div class="reward-row"><span>⭐ Stars</span><strong>245</strong></div>
                    <div class="reward-row"><span>🪙 Coins</span><strong>320</strong></div>
                    <div class="reward-row"><span>🏆 Trophies</span><strong>7</strong></div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card soft-card">
                <div class="card-body">
                    <h3 class="h5 mb-4">Badge System</h3>
                    <div class="row g-3">
                        <?php
                        $badges = ['Alphabet Explorer','Number Master','Shape Genius','Vocabulary Hero','Quiz Champion','Spelling Star'];
                        foreach ($badges as $badge): ?>
                            <div class="col-sm-6 col-md-4 col-xl-2">
                                <div class="badge-card text-center">
                                    <div class="badge-medal">🏅</div>
                                    <strong><?php echo e($badge); ?></strong>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="achievement-popup" id="achievementPopup">
    <span>🎉</span>
    <strong>Achievement Unlocked!</strong>
    <p>Vocabulary Hero</p>
</div>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
