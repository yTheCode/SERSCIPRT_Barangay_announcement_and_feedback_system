

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

// Fetch data
$stmt = $conn->prepare("SELECT title, description FROM announcements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo "Announcement not found.";
    exit();
}
$stmt->bind_result($title, $description);
$stmt->fetch();
$stmt->close();

// Update form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_title = trim($_POST['title']);
    $new_description = trim($_POST['description']);
    if ($new_title === '' || $new_description === '') {
        $error = "All fields are required.";
    } else {
        $update = $conn->prepare("UPDATE announcements SET title = ?, description = ? WHERE id = ?");
        $update->bind_param("ssi", $new_title, $new_description, $id);
        if ($update->execute()) {
            header('Location: manage.php?msg=updated');
            exit();
        } else {
            $error = "Failed to update announcement.";
        }
        $update->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit Announcement</title>
	<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
	<h2>Edit Announcement</h2>
	<?php if (!empty($error)) echo '<p style="color:red">' . htmlspecialchars($error) . '</p>'; ?>
	<form method="post">
		<label>Title:<br>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
		</label><br><br>
		<label>Description:<br>
			<textarea name="description" rows="5" required><?php echo htmlspecialchars($description); ?></textarea>
		</label><br><br>
		<button type="submit">Update</button>
		<a href="manage.php">Cancel</a>
	</form>
</body>
</html>
