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

// Rating labels map
$rating_emojis = array(1 => '😞', 2 => '😕', 3 => '😐', 4 => '🙂', 5 => '😄');

// TODO: Replace sample data with a real SELECT query.
// SQL guy:
// SELECT FeedbackID, ResidentName, Purok, Feedback_Category,
//        Message_Subject, Message_content, Rating, Is_read, DateSubmitted
// FROM FEEDBACK
// ORDER BY DateSubmitted DESC
$feedbacks = array(
    array(
        'FeedbackID'        => 1,
        'ResidentName'      => 'Maria Santos',
        'Purok'             => 'Purok 1 – Sampaguita',
        'Feedback_Category' => 'Infrastructure & Roads',
        'Message_Subject'   => 'Road repair needed on Calle Pasonanca',
        'Message_content'   => 'The road in front of our barangay center has many potholes that need immediate repair. Residents, especially motorcyclists, are at risk of accidents.',
        'Rating'            => 3,
        'Is_read'           => 1,
        'DateSubmitted'     => '2024-05-02',
    ),
    array(
        'FeedbackID'        => 2,
        'ResidentName'      => 'Juan Dela Cruz',
        'Purok'             => 'Purok 2 – Narra',
        'Feedback_Category' => 'Health & Sanitation',
        'Message_Subject'   => 'Thank you for the health program!',
        'Message_content'   => 'The recent health and wellness program organized by the barangay was very helpful to our community. The free check-ups and medicines were greatly appreciated.',
        'Rating'            => 5,
        'Is_read'           => 0,
        'DateSubmitted'     => '2024-05-03',
    ),
    array(
        'FeedbackID'        => 3,
        'ResidentName'      => '',
        'Purok'             => 'Purok 3 – Maharlika',
        'Feedback_Category' => 'Health & Sanitation',
        'Message_Subject'   => 'Request for regular garbage collection schedule',
        'Message_content'   => 'Can the barangay provide a more regular garbage collection schedule? Currently it is inconsistent and sometimes garbage piles up for several days.',
        'Rating'            => 2,
        'Is_read'           => 1,
        'DateSubmitted'     => '2024-05-04',
    ),
);

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
                        <div class="fb-subject"><?= htmlspecialchars($fb['Message_Subject']) ?></div>
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
