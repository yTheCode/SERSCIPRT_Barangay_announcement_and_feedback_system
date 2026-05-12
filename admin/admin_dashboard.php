<?php
/**
 * admin/admin_dashboard.php
 * Admin home page — main navigation hub.
 * Links to Manage Announcements and View Feedback.
 */

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login_admin.php');
    exit;
}

$message  = '';
$username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// TODO: Replace these with real COUNT queries from the database.
// SQL guy: count rows in ANNOUNCEMENT and FEEDBACK tables.
$total_announcements = 2;
$total_feedback      = 3;
$unread_feedback     = 1;

// Get first letter of username for avatar
$avatar_letter = strtoupper(substr($username, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard · Barangay Pasonanca</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Shared stylesheet -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- ══════════════════════════════════════
     ADMIN HEADER
══════════════════════════════════════ -->
<header class="admin-site-header">
    <div class="admin-header-inner">

        <!-- Brand -->
        <div class="admin-brand">
            <div class="admin-brand-badge">Admin Panel</div>
            <div class="admin-brand-name">Barangay Pasonanca</div>
        </div>

        <!-- Navigation -->
        <nav class="admin-nav" aria-label="Admin navigation">
            <a href="admin_dashboard.php"
               class="admin-nav-btn active">
                <span class="nav-icon">🏠</span> Dashboard
            </a>
            <a href="announcements/manage_announcement_dashboard.php"
               class="admin-nav-btn">
                <span class="nav-icon">📢</span> Announcements
            </a>
            <a href="feedback/view_feedback.php"
               class="admin-nav-btn">
                <span class="nav-icon">💬</span> Feedback
                <?php if ($unread_feedback > 0): ?>
                    <span style="background:#e74c3c;color:#fff;font-size:10px;font-weight:700;padding:1px 6px;border-radius:10px;margin-left:2px;"><?= $unread_feedback ?></span>
                <?php endif; ?>
            </a>
        </nav>

        <!-- User + Logout -->
        <div class="admin-header-right">
            <div class="admin-user-chip">
                <div class="admin-avatar"><?= htmlspecialchars($avatar_letter) ?></div>
                <span><?= htmlspecialchars($username) ?></span>
            </div>
            <a href="logout_admin.php" class="admin-logout-btn">
                🚪 Logout
            </a>
        </div>
    </div>
</header>

<!-- ══════════════════════════════════════
     PAGE CONTENT
══════════════════════════════════════ -->
<main class="admin-page">

    <?php if ($message !== ''): ?>
        <div class="alert alert-success flash-msg" style="margin-bottom:20px;">
            ✅ <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <div class="page-title">Admin Dashboard</div>
            <div class="page-sub">Welcome back, <?= htmlspecialchars($username) ?> — here's your overview.</div>
        </div>
    </div>

    <!-- ── STATS CARDS ── -->
    <div class="admin-dash-grid">

        <div class="admin-stat-card">
            <div class="admin-stat-icon green">📢</div>
            <div>
                <div class="admin-stat-num"><?= $total_announcements ?></div>
                <div class="admin-stat-label">Total Announcements</div>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon gold">💬</div>
            <div>
                <div class="admin-stat-num"><?= $total_feedback ?></div>
                <div class="admin-stat-label">Total Feedback</div>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon red">🔔</div>
            <div>
                <div class="admin-stat-num"><?= $unread_feedback ?></div>
                <div class="admin-stat-label">Unread Feedback</div>
            </div>
        </div>

    </div>

    <!-- ── QUICK ACTION CARDS ── -->
    <div class="section-head" style="margin-bottom:16px;">
        <div class="section-title">Quick Actions</div>
    </div>

    <div class="admin-quick-grid">

        <a href="announcements/manage_announcement_dashboard.php" class="admin-action-card">
            <div class="admin-action-icon">📋</div>
            <div>
                <div class="admin-action-title">Manage Announcements</div>
                <div class="admin-action-desc">
                    View, edit, and delete existing announcements. Keep residents
                    informed with up-to-date barangay news and events.
                </div>
            </div>
            <div class="admin-action-arrow">→</div>
        </a>

        <a href="feedback/view_feedback.php" class="admin-action-card">
            <div class="admin-action-icon">📩</div>
            <div>
                <div class="admin-action-title">View Resident Feedback</div>
                <div class="admin-action-desc">
                    Read concerns, suggestions, and inquiries submitted by residents.
                    <?php if ($unread_feedback > 0): ?>
                        <strong style="color:#e74c3c;"><?= $unread_feedback ?> unread</strong> awaiting review.
                    <?php else: ?>
                        All feedback has been reviewed.
                    <?php endif; ?>
                </div>
            </div>
            <div class="admin-action-arrow">→</div>
        </a>

    </div>

    <!-- ── ADMIN NOTES ── -->
    <div class="form-note" style="max-width:640px;">
        <strong>Note for SQL Team:</strong> Replace the sample <code>$total_announcements</code>,
        <code>$total_feedback</code>, and <code>$unread_feedback</code> variables with real
        <code>COUNT()</code> queries from the <code>ANNOUNCEMENT</code> and <code>FEEDBACK</code>
        database tables.
    </div>

</main>

<script src="../assets/js/script.js"></script>
</body>
</html>
