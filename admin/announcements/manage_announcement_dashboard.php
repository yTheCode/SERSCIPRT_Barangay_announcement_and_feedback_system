<?php
/**
 * admin/announcements/manage_announcement_dashboard.php
 * Manage all announcements — view, add, edit, delete.
 */

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login_admin.php');
    exit;
}

$message      = '';
$username     = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';
$avatar_letter = strtoupper(substr($username, 0, 1));

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// TODO: Replace sample data with a database query.
// SQL guy: SELECT AnnouncementID, Title, Description, DatePosted, AdminID
// FROM ANNOUNCEMENT ORDER BY DatePosted DESC
$announcements = array(
    array(
        'AnnouncementID' => 1,
        'Title'          => 'Community Cleanup Drive',
        'Description'    => 'Join us for a community cleanup drive this Saturday at 8:00 AM. Meeting point at the Barangay Hall. Please bring gloves and garbage bags.',
        'DatePosted'     => '2024-05-10',
        'AdminID'        => 1,
    ),
    array(
        'AnnouncementID' => 2,
        'Title'          => 'Health and Wellness Program',
        'Description'    => 'Free health checkup and vaccination program for all residents. Conducted by the DOH and our Barangay Health Center.',
        'DatePosted'     => '2024-05-12',
        'AdminID'        => 1,
    ),
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements · Barangay Pasonanca Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Shared stylesheet -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<!-- ══════════════════════════════════════
     ADMIN HEADER
══════════════════════════════════════ -->
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
            <div class="page-title">📢 Manage Announcements</div>
            <div class="page-sub"><?= count($announcements) ?> announcement<?= count($announcements) !== 1 ? 's' : '' ?> total</div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <a href="../admin_dashboard.php" class="btn-back">← Back to Dashboard</a>
            <a href="add_announcement.php" class="btn-add">＋ Add Announcement</a>
        </div>
    </div>

    <!-- Announcements Table -->
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:48px;">#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th style="width:130px;">Date Posted</th>
                    <th style="width:160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($announcements)): ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <p>No announcements yet. <a href="add_announcement.php" style="color:var(--green-700);font-weight:600;">Add the first one.</a></p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($announcements as $ann): ?>
                        <tr>
                            <td><?= htmlspecialchars($ann['AnnouncementID']) ?></td>
                            <td class="td-title"><?= htmlspecialchars($ann['Title']) ?></td>
                            <td><?= htmlspecialchars(mb_substr($ann['Description'], 0, 80)) ?><?= mb_strlen($ann['Description']) > 80 ? '…' : '' ?></td>
                            <td><?= htmlspecialchars($ann['DatePosted']) ?></td>
                            <td>
                                <div class="actions-cell">
                                    <a href="edit_announcement.php?id=<?= $ann['AnnouncementID'] ?>"
                                       class="btn-edit">✏ Edit</a>
                                    <button class="btn-delete"
                                            onclick="confirmDelete(<?= $ann['AnnouncementID'] ?>, '<?= addslashes($ann['Title']) ?>')">
                                        🗑 Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</main>

<script src="../../assets/js/script.js"></script>
</body>
</html>
