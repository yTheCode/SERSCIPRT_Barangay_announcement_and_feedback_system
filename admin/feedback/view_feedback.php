<?php
/**
 * admin/feedback/view_feedback.php
 * Backend-only: Handle feedback viewing logic
 */

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login_admin.php');
    exit;
}

$message = '';
$feedbacks = array();

// Check for session message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// TODO: Fetch feedback from FEEDBACK table
// SQL guy: execute this query to get all feedback:
// SELECT FeedbackID, ResidentName, Purok, Feedback_Category, Message_Subject, Message_content, Rating, Is_read, DateSubmitted
// FROM FEEDBACK
// ORDER BY DateSubmitted DESC
// Then store the result rows in $feedbacks array
$feedbacks = array(
    array(
        'FeedbackID' => 1,
        'ResidentName' => 'Maria Santos',
        'Purok' => 'Purok 1',
        'Feedback_Category' => 'Infrastructure & Roads',
        'Message_Subject' => 'Road repair needed',
        'Message_content' => 'The road in front of our barangay center has many potholes that need immediate repair.',
        'Rating' => 3,
        'Is_read' => 1,
        'DateSubmitted' => '2024-05-02'
    ),
    array(
        'FeedbackID' => 2,
        'ResidentName' => 'Juan Dela Cruz',
        'Purok' => 'Purok 2',
        'Feedback_Category' => 'Health & Sanitation',
        'Message_Subject' => 'Thank you for health program',
        'Message_content' => 'The recent health and wellness program organized by the barangay was very helpful to our community.',
        'Rating' => 5,
        'Is_read' => 0,
        'DateSubmitted' => '2024-05-03'
    ),
    array(
        'FeedbackID' => 3,
        'ResidentName' => '',
        'Purok' => 'Purok 3',
        'Feedback_Category' => 'Sanitation Services',
        'Message_Subject' => 'Garbage collection schedule',
        'Message_content' => 'Can the barangay provide a more regular garbage collection schedule?',
        'Rating' => 2,
        'Is_read' => 1,
        'DateSubmitted' => '2024-05-04'
    )
);

// Make $feedbacks and $message available for the view layer
$_SESSION['view_feedback_data'] = array(
    'message' => $message,
    'feedbacks' => $feedbacks
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Feedback</title>
</head>
<body>
    <h1>Resident Feedback</h1>
    <a href="../admin_dashboard.php">Back to Dashboard</a>

    <?php if ($message != ''): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>FeedbackID</th>
                <th>Resident Name</th>
                <th>Purok</th>
                <th>Category</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($feedbacks)): ?>
                <tr>
                    <td colspan="9">No feedback found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($feedbacks as $feedback): ?>
                    <tr>
                        <td><?= $feedback['FeedbackID'] ?></td>
                        <td><?= htmlspecialchars($feedback['ResidentName'] != '' ? $feedback['ResidentName'] : '(Anonymous)') ?></td>
                        <td><?= htmlspecialchars($feedback['Purok']) ?></td>
                        <td><?= htmlspecialchars($feedback['Feedback_Category']) ?></td>
                        <td><?= htmlspecialchars($feedback['Message_Subject']) ?></td>
                        <td><?= htmlspecialchars(substr($feedback['Message_content'], 0, 50)) ?>...</td>
                        <td><?= $feedback['Rating'] ?>/5</td>
                        <td><?= $feedback['Is_read'] == 1 ? 'Read' : 'Unread' ?></td>
                        <td><?= $feedback['DateSubmitted'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
