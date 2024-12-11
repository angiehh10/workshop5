<?php
require('../utils/functions.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (deleteUser($id)) {
        header('Location: /users.php');
        exit;
    } else {
        echo "Error deleting user.";
    }
}
?>
