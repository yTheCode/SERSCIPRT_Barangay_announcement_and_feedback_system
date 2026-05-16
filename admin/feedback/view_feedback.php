<?php
/**
 * admin/feedback/view_feedback.php
 * View and manage resident feedback submissions.
 */

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login_admin.php');
    exit;
}

$message       = '';
$username      = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';
$avatar_letter = strtoupper(substr($username, 0, 1));

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Handle mark-as-read POST from this page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read_id'])) {
    $markId = (int) $_POST['mark_read_id'];
    $dbUp = @mysqli_connect('127.0.0.1', 'root', '', 'barangay_system');
    if ($dbUp) {
        $markIdEsc = mysqli_real_escape_string($dbUp, (string)$markId);
        mysqli_query($dbUp, "UPDATE feedback SET Is_read = 1 WHERE FeedbackID = {$markIdEsc}");
        mysqli_close($dbUp);
    }
    // redirect to avoid form resubmission and to show updated list
    header('Location: view_feedback.php');
    exit;
}

// Rating labels map
$rating_emojis = array(1 => '😞', 2 => '😕', 3 => '😐', 4 => '🙂', 5 => '😄');

// Try to load from database; if unavailable, fall back to sample data below.
$feedbacks = array();
$dbConn = @mysqli_connect('127.0.0.1', 'root', '', 'barangay_system');
if ($dbConn) {
    mysqli_set_charset($dbConn, 'utf8mb4');
    $sql = "SELECT FeedbackID, ResidentName, Purok, Feedback_Category, Message_Subject, Message_content, Rating, Is_read, DateSubmitted FROM feedback ORDER BY DateSubmitted DESC";
    if ($res = mysqli_query($dbConn, $sql)) {
        while ($row = mysqli_fetch_assoc($res)) {
            // Normalize types
            $row['Rating'] = isset($row['Rating']) ? (int)$row['Rating'] : 0;
            $row['Is_read'] = isset($row['Is_read']) ? (int)$row['Is_read'] : 0;
            $feedbacks[] = $row;
        }
        mysqli_free_result($res);
    }
    mysqli_close($dbConn);
}

// No sample/fallback data — when the database has no feedback rows the page
// will display the empty-state message. This keeps the admin view honest.

// Count unread
$unread_count = 0;
foreach ($feedbacks as $fb) {
    if (!$fb['Is_read']) $unread_count++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback · Barangay Pasonanca Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Shared stylesheet -->
    <link rel="stylesheet" href="../../assets/style/style.css">
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
            <a href="../announcements/manage_announcement_dashboard.php" class="admin-nav-btn">
                <span class="nav-icon">📢</span> Announcements
            </a>
            <a href="view_feedback.php" class="admin-nav-btn active">
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

    <?php if ($message !== ''): ?>
        <div class="alert alert-success flash-msg" style="margin-bottom:20px;">
            ✅ <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <div class="page-title">💬 Resident Feedback</div>
            <div class="page-sub">
                <?= count($feedbacks) ?> submission<?= count($feedbacks) !== 1 ? 's' : '' ?>
                <?php if ($unread_count > 0): ?>
                    &nbsp;·&nbsp; <span style="color:#e74c3c;font-weight:700;"><?= $unread_count ?> unread</span>
                <?php endif; ?>
            </div>
        </div>
        <a href="../admin_dashboard.php" class="btn-back">← Back to Dashboard</a>
    </div>

    <!-- Filter row -->
    <div class="filter-row">
        <label style="font-size:13px;color:var(--gray-600);font-weight:600;">Filter:</label>
        <select class="filter-select" onchange="filterFeedback(this.value)">
            <option value="all">All Feedback</option>
            <option value="unread">Unread Only</option>
            <option value="read">Read Only</option>
        </select>
    </div>

    <!-- Feedback Cards -->
    <?php if (empty($feedbacks)): ?>
        <div class="empty-state" style="background:var(--white);border-radius:var(--radius-md);border:1.5px solid var(--gray-200);">
            <div class="empty-icon">📭</div>
            <p>No feedback submissions yet.</p>
        </div>
    <?php else: ?>
        <?php foreach ($feedbacks as $fb): ?>
            <div class="fb-card" data-status="<?= $fb['Is_read'] ? 'read' : 'unread' ?>">
                <div class="fb-card-head">

                    <?php if (!$fb['Is_read']): ?>
                        <div class="unread-indicator" title="Unread"></div>
                    <?php else: ?>
                        <div style="width:8px;flex-shrink:0;"></div>
                    <?php endif; ?>

                    <div class="fb-meta">
                        <div class="fb-subject"><a href="view_feedback.php?view_id=<?= urlencode($fb['FeedbackID']) ?>"><?= htmlspecialchars($fb['Message_Subject']) ?></a></div>
                        <div class="fb-info">
                            <span>👤 <?= $fb['ResidentName'] !== '' ? htmlspecialchars($fb['ResidentName']) : '<em>Anonymous</em>' ?></span>
                            <span>📍 <?= htmlspecialchars($fb['Purok']) ?></span>
                            <span>📅 <?= htmlspecialchars($fb['DateSubmitted']) ?></span>
                        </div>
                    </div>

                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;flex-shrink:0;">
                        <span class="fb-category-badge"><?= htmlspecialchars($fb['Feedback_Category']) ?></span>
                        <span class="<?= $fb['Is_read'] ? 'status-read' : 'status-unread' ?>">
                            <?= $fb['Is_read'] ? '✓ Read' : '● Unread' ?>
                        </span>
                        <?php if (!$fb['Is_read']): ?>
                            <form method="post" style="margin-top:6px;">
                                <input type="hidden" name="mark_read_id" value="<?= htmlspecialchars($fb['FeedbackID']) ?>">
                                <button type="submit" class="btn-small">Mark as read</button>
                            </form>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="fb-body-border"></div>

                <div class="fb-body">
                    <?= htmlspecialchars($fb['Message_content']) ?>
                </div>

                <div class="fb-rating">
                    <span class="fb-rating-label">Rating:</span>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        $emoji = isset($rating_emojis[$i]) ? $rating_emojis[$i] : '⭐';
                        if ($i == $fb['Rating']) {
                            echo '<span style="font-size:22px;" title="' . $emoji . '">' . $emoji . '</span>';
                        } else {
                            echo '<span style="font-size:18px;opacity:.35;" title="' . ($rating_emojis[$i] ?? '') . '">' . ($rating_emojis[$i] ?? '⭐') . '</span>';
                        }
                    }
                    ?>
                    <span style="font-size:12px;color:var(--gray-600);margin-left:4px;"><?= $fb['Rating'] ?>/5</span>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Detail view modal / panel when view_id is present -->
    <?php if (isset($_GET['view_id'])):
        $viewId = (int)$_GET['view_id'];
        // find in loaded feedbacks
        $detail = null;
        foreach ($feedbacks as $f) if ((int)$f['FeedbackID'] === $viewId) { $detail = $f; break; }
    ?>
        <?php if ($detail): ?>
            <div class="fb-detail-panel">
                <div class="fb-detail-head">
                    <h3><?= htmlspecialchars($detail['Message_Subject']) ?></h3>
                    <div style="font-size:13px;color:var(--gray-600);">👤 <?= $detail['ResidentName'] !== '' ? htmlspecialchars($detail['ResidentName']) : '<em>Anonymous</em>' ?> · 📍 <?= htmlspecialchars($detail['Purok']) ?> · 📅 <?= htmlspecialchars($detail['DateSubmitted']) ?></div>
                </div>
                <div class="fb-detail-body" style="margin-top:12px;">
                    <?= nl2br(htmlspecialchars($detail['Message_content'])) ?>
                </div>
                <div style="margin-top:12px;">
                    <?php if (!$detail['Is_read']): ?>
                        <form method="post"><input type="hidden" name="mark_read_id" value="<?= htmlspecialchars($detail['FeedbackID']) ?>"><button type="submit" class="btn-primary">Mark as Read</button></form>
                    <?php else: ?>
                        <span class="status-read">✓ Read</span>
                    <?php endif; ?>
                    <a href="view_feedback.php" class="btn-link" style="margin-left:12px;">Close</a>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</main>

<script src="../../assets/js/script.js"></script>
<script>
function filterFeedback(value) {
    document.querySelectorAll('.fb-card').forEach(card => {
        if (value === 'all') {
            card.style.display = '';
        } else {
            card.style.display = card.dataset.status === value ? '' : 'none';
        }
    });
}
</script>
</body>
</html>
