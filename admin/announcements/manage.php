<?php
/**
 * admin/announcements/manage.php
 * Manage all announcements
 */

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

$message = '';

// Check for session message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// TODO: Fetch announcements from ANNOUNCEMENT table
// replace this sample data with a query result from the database.
// The query should return these columns for each announcement:
// AnnouncementID, Title, Description, DatePosted, AdminID
$announcements = array(
    // These entries below are fake data for testing the page.
    array(
        'AnnouncementID' => 1,
        'Title' => 'Community Cleanup Drive',
        'Description' => 'Join us for a community cleanup drive this Saturday at 8:00 AM.',
        'DatePosted' => '2024-05-10',
        'AdminID' => 1
    ),
    array(
        'AnnouncementID' => 2,
        'Title' => 'Health and Wellness Program',
        'Description' => 'Free health checkup and vaccination program for all residents.',
        'DatePosted' => '2024-05-12',
        'AdminID' => 1
    )
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Announcements</title>
</head>
<body>
    <h1>Manage Announcements</h1>
    <a href="add.php">Add New Announcement</a>
    
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <table border="1">
        <thead>
            <tr>
                <th>AnnouncementID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date Posted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($announcements)): ?>
                <tr>
                    <td colspan="5">No announcements found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($announcements as $announcement): ?>
                    <tr>
                        <td><?= $announcement['AnnouncementID'] ?></td>
                        <td><?= htmlspecialchars($announcement['Title']) ?></td>
                        <td><?= htmlspecialchars(substr($announcement['Description'], 0, 50)) ?>...</td>
                        <td><?= $announcement['DatePosted'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $announcement['AnnouncementID'] ?>">Edit</a>
                            <a href="delete.php?id=<?= $announcement['AnnouncementID'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
