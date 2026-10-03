<?php
require __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = sanitize_text($_POST['nickname'] ?? '');
    $avatar = sanitize_text($_POST['avatar'] ?? '🙂');
    if ($nickname === '') {
        $nickname = 'Learner';
    }

    $_SESSION['readready_nickname'] = $nickname;
    $_SESSION['readready_avatar'] = $avatar;
    header('Location: ' . APP_BASE_URL . '/dashboard.php');
    exit;
}

$selectedAvatar = $_SESSION['readready_avatar'] ?? '🙂';
$nickname = $_SESSION['readready_nickname'] ?? 'Learner';
require __DIR__ . '/includes/header.php';
?>

<section class="welcome-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card welcome-card shadow-lg border-0">
                    <div class="card-body p-4 p-md-5 text-center">
                        <div class="mb-3">
                            <span class="app-badge">ReadReady</span>
                        </div>
                        <h1 class="display-5 fw-bold text-primary mb-3">Welcome to ReadReady</h1>
                        <p class="lead text-muted mb-4">A joyful world of reading, numbers, shapes, and learning adventures for little minds.</p>

                        <form method="post" action="<?php echo APP_BASE_URL; ?>/index.php" class="text-start">
                            <div class="mb-3">
                                <label for="nickname" class="form-label fw-bold">Nickname</label>
                                <input id="nickname" name="nickname" type="text" class="form-control form-control-lg" value="<?php echo e($nickname); ?>" maxlength="20" placeholder="Enter your nickname" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Choose Avatar</label>
                                <div class="avatar-picker row g-2" id="avatar-picker">
                                    <?php $avatars = ['🙂','🐼','🦊','🐸','🦁','🐰']; foreach ($avatars as $choice): ?>
                                        <div class="col-auto">
                                            <button type="button" class="avatar-option btn btn-outline-primary <?php echo ($choice === $selectedAvatar) ? 'active' : ''; ?>" data-avatar="<?php echo e($choice); ?>" aria-label="Choose avatar <?php echo e($choice); ?>"><?php echo e($choice); ?></button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" id="avatar" name="avatar" value="<?php echo e($selectedAvatar); ?>">
                            </div>

                            <button type="submit" class="btn btn-start btn-lg w-100">
                                <i class="bi bi-play-circle me-2"></i> Start Learning
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
