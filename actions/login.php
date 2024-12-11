<?php
require('../utils/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user = authenticate($username, $password);

    if ($user) {
        session_start();
        $_SESSION['user'] = $user;
        header('Location: /xamp_folder/users.php');
        exit();
    } else {
        header('Location: /xamp_folder/index1.php?error=login');
        exit();
    }
}
?>
