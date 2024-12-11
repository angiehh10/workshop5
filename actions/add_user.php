<?php
require('../utils/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'role' => $_POST['role']
    ];

    if (saveUser($user)) {
        header('Location: /users.php');
        exit;
    } else {
        echo "Error adding user.";
    }
}
?>
