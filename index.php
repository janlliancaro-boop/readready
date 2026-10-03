<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = sanitize_text($_POST['nickname'] ?? '');
    $avatar = sanitize_text($_POST['avatar'] ?? '🙂');

    if (empty($nickname)) {
        $error = 'Please enter a nickname.';
    } elseif (strlen($nickname) < 2) {
        $error = 'Nickname must be at least 2 characters.';
    } else {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            // Check if nickname already exists
            $check = $conn->prepare('SELECT id FROM learners WHERE nickname = ?');
            $check->bind_param('s', $nickname);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $error = 'This nickname is already taken. Please choose another.';
            } else {
                // Insert new learner
                $stmt = $conn->prepare('INSERT INTO learners (nickname, avatar) VALUES (?, ?)');
                $stmt->bind_param('ss', $nickname, $avatar);

                if ($stmt->execute()) {
                    $learner_id = $stmt->insert_id;
                    $_SESSION['learner_id'] = $learner_id;
                    $_SESSION['readready_nickname'] = $nickname;
                    $_SESSION['readready_avatar'] = $avatar;
                    
                    redirect('/dashboard.php');
                } else {
                    $error = 'Error creating account. Please try again.';
                }
                $stmt->close();
            }
            $check->close();
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}

$selectedAvatar = $_POST['avatar'] ?? '🙂';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo APP_BASE_URL; ?>/assets/css/style.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?php echo APP_BASE_URL; ?>/">📚 ReadReady</a>
        </div>
    </nav>

    <section class="welcome-wrapper py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-9">
                    <div class="card welcome-card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="display-5 fw-bold text-primary mb-3">Welcome to ReadReady</h1>
                            <p class="lead text-muted mb-4">A joyful world of reading, numbers, shapes, and learning adventures for little minds.</p>

                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-circle"></i> <?php echo e($error); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="<?php echo APP_BASE_URL; ?>/index.php" class="text-start">
                                <div class="mb-3">
                                    <label for="nickname" class="form-label fw-bold">Your Nickname</label>
                                    <input id="nickname" name="nickname" type="text" class="form-control form-control-lg" 
                                           value="<?php echo e($nickname ?? ''); ?>" maxlength="50" placeholder="Enter your nickname" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Choose Avatar</label>
                                    <div class="avatar-picker row g-2" id="avatar-picker">
                                        <?php $avatars = ['🙂','🐼','🦊','🐸','🦁','🐰']; foreach ($avatars as $choice): ?>
                                            <div class="col-auto">
                                                <button type="button" class="avatar-option btn btn-outline-primary <?php echo ($choice === $selectedAvatar) ? 'active' : ''; ?>" 
                                                        data-avatar="<?php echo e($choice); ?>">
                                                    <?php echo $choice; ?>
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" id="avatar" name="avatar" value="<?php echo e($selectedAvatar); ?>">
                                </div>

                                <button type="submit" class="btn btn-start btn-lg w-100">
                                    <i class="bi bi-play-circle me-2"></i> Start Learning
                                </button>
                            </form>

                            <hr class="my-4">

                            <p class="text-center text-muted mb-0">
                                Already created your account? <a href="<?php echo APP_BASE_URL; ?>/login.php" class="text-primary fw-bold">Login here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.avatar-option').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.avatar-option').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('avatar').value = this.getAttribute('data-avatar');
            });
        });
    </script>
</body>
</html>
