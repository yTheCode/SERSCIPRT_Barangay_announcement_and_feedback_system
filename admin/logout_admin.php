<?php
/**
 * admin/logout_admin.php
 * Destroys the admin session and redirects to the login page.
 */

session_start();
session_unset();
session_destroy();

header('Location: login_admin.php');
exit;
