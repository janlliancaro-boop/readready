<?php
$active = $active ?? 'home';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo APP_BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?php echo APP_BASE_URL; ?>/index.php">📚 ReadReady</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo $active === 'home' ? 'active' : ''; ?>" href="<?php echo APP_BASE_URL; ?>/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $active === 'dictionary' ? 'active' : ''; ?>" href="<?php echo APP_BASE_URL; ?>/modules/dictionary/index.php">Dictionary</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $active === 'nursery' ? 'active' : ''; ?>" href="<?php echo APP_BASE_URL; ?>/modules/nursery/index.php">Nursery</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $active === 'quiz' ? 'active' : ''; ?>" href="<?php echo APP_BASE_URL; ?>/modules/quiz/index.php">Quiz</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $active === 'rewards' ? 'active' : ''; ?>" href="<?php echo APP_BASE_URL; ?>/modules/rewards/index.php">Rewards</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $active === 'admin' ? 'active' : ''; ?>" href="<?php echo APP_BASE_URL; ?>/admin/index.php">Admin</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <span class="user-pill"><?php echo e($_SESSION['readready_avatar'] ?? '🙂'); ?> <?php echo e($_SESSION['readready_nickname'] ?? 'Learner'); ?></span>
                </div>
            </div>
        </div>
    </nav>
