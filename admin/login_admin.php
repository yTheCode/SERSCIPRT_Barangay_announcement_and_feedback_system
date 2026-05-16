<?php
/**
 * admin/login_admin.php
 * ADMIN-ONLY login interface.
 *
 * Access only by typing the URL directly: /admin/login_admin.php
 * No link to this page exists anywhere in the public site.
 */

session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
    header('Location: admin_dashboard.php');
    exit;
}

$error    = '';
$username = '';

// TODO: Replace this with a real database query.
// SQL guy: verify the submitted username/password against the admin table.
// On success, set $_SESSION['admin_logged_in'] = true and redirect.
$sample_admin_username = 'admin';
$sample_admin_password = 'admin123';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password']      : '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } elseif ($username === $sample_admin_username && $password === $sample_admin_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username']  = $username;
        $_SESSION['message']         = 'Welcome back, ' . htmlspecialchars($username) . '!';
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login · Barangay Pasonanca</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Shared stylesheet -->
    <link rel="stylesheet" href="../assets/style/style.css">
</head>
<body class="admin-login-page">

<div class="admin-card">

    <!-- Header -->
    <div class="admin-header">
        <div class="admin-badge">🔒 Restricted Access</div>
        <div class="admin-title">Barangay Pasonanca</div>
        <div class="admin-sub">Administrator Panel</div>
    </div>

    <!-- Body -->
    <div class="admin-body">

        <?php if ($error !== ''): ?>
            <div class="alert alert-error">
                ⚠ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="login_admin.php" onsubmit="return handleAdminLogin();">

            <div class="lock-icon" aria-hidden="true">🔑</div>

            <div class="form-group">
                <label class="form-label" for="admin-user">Admin Username <span>*</span></label>
                <div class="input-row">
                    <input  class="form-input has-icon"
                            type="text"
                            id="admin-user"
                            name="username"
                            value="<?= htmlspecialchars($username) ?>"
                            placeholder="admin"
                            autocomplete="username">
                    <span class="input-icon" aria-hidden="true">👤</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="admin-pass">Password <span>*</span></label>
                <div class="input-row">
                    <input  class="form-input has-icon"
                            type="password"
                            id="admin-pass"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password">
                    <span   class="input-icon"
                            onclick="togglePw('admin-pass', this)"
                            title="Show / hide password"
                            role="button"
                            tabindex="0"
                            aria-label="Toggle password visibility">👁</span>
                </div>
            </div>

            <button class="btn-primary" type="submit">
                🔓 Sign In to Admin Panel
            </button>
        </form>

        <hr class="admin-divider">

        <div class="admin-back-link">
            Not an admin? <a href="/public/index.php">Return to Home</a>
        </div>

    </div><!-- /admin-body -->
</div><!-- /admin-card -->

<script src="../assets/js/script.js"></script>
</body>
</html>
