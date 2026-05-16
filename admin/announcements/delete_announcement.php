<?php

session_start();
require_once '../../config/db.php';

// Auth check
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

// Get ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "Invalid announcement ID.";
    exit();
}

// Confirm delete
if (!isset($_GET['confirm'])) {
    echo '<h2>Delete Announcement</h2>';
    echo '<p>Are you sure you want to delete this announcement?</p>';
    echo '<a href="delete_announcement.php?id=' . $id . '&confirm=1">Yes, Delete</a> | <a href="manage_announcement_dashboard.php">Cancel</a>';
    exit();
}

// Delete row
$stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header('Location: manage_announcement_dashboard.php?msg=deleted');
    exit();
} else {
    echo "Failed to delete announcement.";
}
$stmt->close();
?>
