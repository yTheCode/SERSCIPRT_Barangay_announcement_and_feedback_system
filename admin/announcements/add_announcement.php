<?php
/**
 * admin/announcements/add_announcement.php
 * Add a new announcement.
 */

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login_admin.php');
    exit;
}

$username     = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';
$avatar_letter = strtoupper(substr($username, 0, 1));
$errors       = array();
$form         = array('title' => '', 'description' => '', 'date_posted' => date('Y-m-d'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['title']       = isset($_POST['title'])       ? trim($_POST['title'])       : '';
    $form['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
    $form['date_posted'] = isset($_POST['date_posted']) ? trim($_POST['date_posted']) : '';
    $admin_id            = isset($_SESSION['AdminID'])  ? $_SESSION['AdminID']        : 1;

    // Validation
    if ($form['title'] === '') {
        $errors[] = 'Title is required.';
    } elseif (mb_strlen($form['title']) > 150) {
        $errors[] = 'Title must be 150 characters or fewer.';
    }

    if ($form['description'] === '') {
        $errors[] = 'Description is required.';
    }

    if ($form['date_posted'] === '') {
        $errors[] = 'Date posted is required.';
    }

    if (empty($errors)) {
        // TODO: DATABASE INSERTION
        // SQL guy: INSERT INTO ANNOUNCEMENT (Title, Description, DatePosted, AdminID)
        // VALUES ($form['title'], $form['description'], $form['date_posted'], $admin_id)
        // After successful insert, set flash message and redirect.

        $_SESSION['message'] = 'Announcement "' . htmlspecialchars($form['title']) . '" was posted successfully!';
        header('Location: manage_announcement_dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Announcement · Barangay Pasonanca Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Shared stylesheet -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<!-- ADMIN HEADER -->
<header class="admin-site-header">
    <div class="admin-header-inner">
        <div class="admin-brand">
            <div class="admin-brand-badge">Admin Panel</div>
            <div class="admin-brand-name">Barangay Pasonanca</div>
        </div>
        <nav class="admin-nav">
            <a href="../admin_dashboard.php" class="admin-nav-btn">
                <span class="nav-icon">🏠</span> Dashboard
            </a>
            <a href="manage_announcement_dashboard.php" class="admin-nav-btn active">
                <span class="nav-icon">📢</span> Announcements
            </a>
            <a href="../feedback/view_feedback.php" class="admin-nav-btn">
                <span class="nav-icon">💬</span> Feedback
            </a>
        </nav>
        <div class="admin-header-right">
            <div class="admin-user-chip">
                <div class="admin-avatar"><?= htmlspecialchars($avatar_letter) ?></div>
                <span><?= htmlspecialchars($username) ?></span>
            </div>
            <a href="../logout_admin.php" class="admin-logout-btn">🚪 Logout</a>
        </div>
    </div>
</header>

<!-- PAGE CONTENT -->
<main class="admin-page">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <div class="page-title">➕ Add Announcement</div>
            <div class="page-sub">Create a new barangay announcement for residents.</div>
        </div>
        <a href="manage_announcement_dashboard.php" class="btn-back">← Back to Announcements</a>
    </div>

    <!-- Form Card -->
    <div class="admin-form-card">
        <div class="admin-form-header">
            <h2>New Announcement</h2>
            <p>Fill in the details below and click <strong>Post</strong> to publish.</p>
        </div>

        <div class="admin-form-body">

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error" style="margin-bottom:20px;">
                    <div>
                        <strong>⚠ Please fix the following:</strong>
                        <ul style="margin-top:6px;margin-left:16px;">
                            <?php foreach ($errors as $e): ?>
                                <li><?= htmlspecialchars($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="add_announcement.php">

                <div class="form-group">
                    <label class="form-label" for="ann-title">
                        Announcement Title <span>*</span>
                    </label>
                    <input  class="form-input"
                            type="text"
                            id="ann-title"
                            name="title"
                            value="<?= htmlspecialchars($form['title']) ?>"
                            placeholder="e.g. Community Clean-up Drive"
                            maxlength="150">
                    <div class="form-helper">Max 150 characters.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="ann-description">
                        Description / Body <span>*</span>
                    </label>
                    <textarea   class="form-textarea"
                                id="ann-description"
                                name="description"
                                placeholder="Write the full announcement text here..."
                                style="min-height:140px;"><?= htmlspecialchars($form['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="ann-date">
                        Date Posted <span>*</span>
                    </label>
                    <input  class="form-input"
                            type="date"
                            id="ann-date"
                            name="date_posted"
                            value="<?= htmlspecialchars($form['date_posted']) ?>">
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn-add" style="flex:1;justify-content:center;padding:13px;">
                        📢 Post Announcement
                    </button>
                    <a href="manage_announcement_dashboard.php" class="btn-back" style="padding:13px 20px;">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

</main>

<script src="../../assets/js/script.js"></script>
</body>
</html>
