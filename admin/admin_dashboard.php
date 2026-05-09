<?php
/**
 * admin/dashboard.php
 * Admin home page.
 */

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
	header('Location: login_admin.php');
	exit;
}

$message = '';
$username = '';

if (isset($_SESSION['message'])) {
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}

if (isset($_SESSION['admin_username'])) {
	$username = $_SESSION['admin_username'];
}

// TODO: Replace these sample values with database COUNT queries.
// SQL guy: count announcements, unread feedback, and total feedback records.
$total_announcements = 2;
$total_feedback = 2;
$unread_feedback = 1;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
</head>
<body>
	<h1>Admin Dashboard</h1>

	<?php if ($message != ''): ?>
		<p><?= htmlspecialchars($message) ?></p>
	<?php endif; ?>

	<p>Welcome<?php if ($username != ''): ?>, <?= htmlspecialchars($username) ?><?php endif; ?>.</p>

	<h2>Quick Summary</h2>
	<ul>
		<li>Total Announcements: <?= $total_announcements ?></li>
		<li>Total Feedback: <?= $total_feedback ?></li>
		<li>Unread Feedback: <?= $unread_feedback ?></li>
	</ul>

	<h2>Admin Links</h2>
	<ul>
		<li><a href="announcements/manage_announcement_dashboard.php">Manage Announcements</a></li>
		<li><a href="announcements/add_announcement.php">Add Announcement</a></li>
		<li><a href="feedback/view_feedback.php">View Feedback</a></li>
		<li><a href="logout_admin.php">Logout</a></li>
	</ul>

	<h2>Notes for SQL Team</h2>
	<p>The dashboard should later use real database counts and recent records from the ANNOUNCEMENT and FEEDBACK tables.</p>
</body>
</html>
