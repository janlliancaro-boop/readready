<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/database.php';

if (is_admin_logged_in()) {
    redirect('/admin/dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_text($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } else {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT id, username, password_hash, status FROM admins WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if ($admin['status'] === 'active' && password_verify($password, $admin['password_hash'])) {
                $_SESSION['admin_id'] = (int) $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                redirect('/admin/dashboard.php');
            }
        }

        $error = 'Invalid username or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo APP_BASE_URL; ?>/assets/css/style.css" />
</head>
<body class="bg-light">
    <section class="welcome-wrapper py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card welcome-card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">
                            <p class="text-uppercase small text-danger fw-bold mb-1">Admin Access</p>
                            <h1 class="display-6 fw-bold text-danger">Secure Login</h1>
                            <p class="text-muted">Use your username and password to access the admin system.</p>

                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?php echo e($error); ?></div>
                            <?php endif; ?>

                            <form method="post" action="<?php echo APP_BASE_URL; ?>/admin/login.php">
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-bold">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button class="btn btn-danger w-100" type="submit">Login</button>
                            </form>

                            <div class="mt-3 small text-muted">Default admin credentials: admin / admin123</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
