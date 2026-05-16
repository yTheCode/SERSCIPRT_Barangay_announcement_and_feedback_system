<?php

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login_admin.php');
    exit();
}

// Get ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "Invalid announcement ID.";
    exit();
}

require_once __DIR__ . '/../../config/db.php';

// Delete row
$stmt = $conn->prepare("DELETE FROM announcements WHERE ID = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $_SESSION['message'] = 'Announcement deleted successfully.';
    header('Location: manage_announcement_dashboard.php');
    exit();
} else {
    echo "Failed to delete announcement.";
}
$stmt->close();
?>
