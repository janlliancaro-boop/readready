<?php
if (!is_admin_logged_in()) {
    redirect('/admin/login.php');
}

$database = new Database();
$conn = $database->getConnection();
