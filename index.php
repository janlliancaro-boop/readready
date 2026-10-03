<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = sanitize_text($_POST['nickname'] ?? '');
    $avatar = sanitize_text($_POST['avatar'] ?? '🙂');
    $csrf = $_POST['csrf_token'] ?? '';

    if ($csrf !== $_SESSION['csrf_token'] ?? '') {
        $error = 'Security token mismatch. Please try again.';
    } elseif ($nickname === '') {
        $error = 'Please enter a nickname.';
    } elseif (mb_strlen($nickname) < 2) {
        $error = 'Nickname must be at least 2 characters.';
    } else {
        try {
            $database = new Database();
            $conn = $database->getConnection();
            $learnerToken = generate_token(32);

            $stmt = $conn->prepare('INSERT INTO learners (learner_token, nickname, avatar, current_level, stars, coins, total_badges, total_achievements) VALUES (?, ?, ?, ?, 0, 0, 0, 0)');
            $stmt->bind_param('ssss', $learnerToken, $nickname, $avatar, $level);
            $level = 'Beginner';
            $stmt->execute();
            $learnerId = $conn->insert_id;
            $stmt->close();

            $_SESSION['learner_id'] = $learnerId;
            $_SESSION['learner_token'] = $learnerToken;
            $_SESSION['readready_nickname'] = $nickname;
            $_SESSION['readready_avatar'] = $avatar;
            $_SESSION['learner_current_level'] = 'Beginner';

            $insertProgress = $conn->prepare('INSERT INTO learner_progress (learner_id, lessons_completed, activities_completed, words_learned, progress_percent, quiz_score_total) VALUES (?, 0, 0, 0, 0, 0)');
            $insertProgress->bind_param('i', $learnerId);
            $insertProgress->execute();
            $insertProgress->close();

            $success = 'Profile created successfully.';
            redirect('/dashboard.php');
        } catch (Throwable $e) {
            $error = 'Unable to create learner profile: ' . $e->getMessage();
        }
    }
}

if (empty($_SESSION['csrf_token'] ?? '')) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$selectedAvatar = $_POST['avatar'] ?? '🙂';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadReady</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo APP_BASE_URL; ?>/assets/css/style.css" />
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?php echo APP_BASE_URL; ?>/">📚 ReadReady</a>
            <a class="btn btn-outline-primary btn-sm" href="<?php echo APP_BASE_URL; ?>/admin/login.php">Admin</a>
        </div>
    </nav>

    <section class="welcome-wrapper py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-9">
                    <div class="card welcome-card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">
                            <span class="app-badge">Open to all learners</span>
                            <h1 class="display-5 fw-bold text-primary mt-3 mb-3">Welcome to ReadReady</h1>
                            <p class="lead text-muted">Create your nick name, pick an avatar, and begin a joyful learning adventure.</p>

                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo e($error); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="<?php echo APP_BASE_URL; ?>/index.php" class="text-start">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="nickname" class="form-label fw-bold">Enter Nickname</label>
                                    <input id="nickname" name="nickname" type="text" class="form-control form-control-lg" value="<?php echo e($_POST['nickname'] ?? ''); ?>" maxlength="50" placeholder="Enter nickname" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Choose Avatar</label>
                                    <div class="avatar-picker row g-2" id="avatar-picker">
                                        <?php $avatars = ['🙂', '🐼', '🦊', '🐸', '🦁', '🐰']; foreach ($avatars as $choice): ?>
                                            <div class="col-auto">
                                                <button type="button" class="avatar-option btn btn-outline-primary <?php echo ($choice === $selectedAvatar) ? 'active' : ''; ?>" data-avatar="<?php echo e($choice); ?>"><?php echo $choice; ?></button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.avatar-option').forEach(button => {
            button.addEventListener('click', function () {
                document.querySelectorAll('.avatar-option').forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('avatar').value = this.dataset.avatar;
            });
        });
    </script>
</body>
</html>
