<?php
require '../templates/helper.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $hashed = hash('sha256', $_POST['password']);

    $sth = $db->prepare("SELECT * FROM users WHERE `email`=? AND `password`=?");
    $sth->execute([$_POST['email'], $hashed]);
    $user = $sth->fetchAll();

    if (empty($user)) {
        echo "Not logged in";
    } else {
        echo "Logged in";
    }
}