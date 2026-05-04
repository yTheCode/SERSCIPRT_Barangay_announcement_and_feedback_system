
<?php
// Add a new announcement
session_start();
// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = '';
    $description = '';
    $date_posted = '';
    $admin_id = '';
   
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
    }
    if (isset($_POST['description'])) {
        $description = $_POST['description'];
    }
    if (isset($_POST['date_posted'])) {
        $date_posted = $_POST['date_posted'];
    }
    if (isset($_SESSION['AdminID'])) {
        $admin_id = $_SESSION['AdminID'];
    }
    
    // For validation 
    $errors = array();
    if (empty($title)) {
        $errors[] = 'Title is required';
    }
    if (empty($description)) {
        $errors[] = 'Description is required';
    }
    if (empty($date_posted)) {
        $errors[] = 'Date Posted is required';
    }
    if (empty($admin_id)) {
        $errors[] = 'Admin ID not found in session';
    }
    
    if (empty($errors)) {
        // TODO: DATABASE INSERTION For sql 
        // Insert into ANNOUNCEMENT table with columns:
        // - Title: $title
        // - Description: $description
        // - DatePosted: $date_posted
        // - AdminID: $admin_id (Foreign Key)
        // After successful insert, set success message and redirect
        
        $_SESSION['message'] = 'Announcement added successfully!';
        header('Location: manage.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Announcement</title>
</head>
<body>
    <h1>Add Announcement</h1>
    <a href="manage.php">Back</a>
    
    <?php if (!empty($errors)): ?>
        <div>
            <p>Please fix the following errors:</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" required>
        
        <label>Description:</label>
        <textarea name="description" required></textarea>
        
        <label>Date Posted:</label>
        <input type="date" name="date_posted" value="<?php echo date('Y-m-d'); ?>" required>
        
        <button type="submit">Add Announcement</button>
        <a href="manage.php">Cancel</a>
    </form>
</body>
</html>
