<?php
require '../templates/helper.php';

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['org'])) {
    $hashed = hash('sha256', $_POST['password']);

    $sth = $db->prepare("SELECT * FROM `users` WHERE `email`=?");
    $sth->execute([$_POST['email'], $hashed]);
    $user = $sth->fetchAll();

    if (empty($user)) {
        $sth = $db->prepare("INSERT INTO `users` (`email`, `password`, `org`) VALUES (?, ?, ?)");
        $sth->execute([$_POST['email'], $hashed, $_POST['org']]);

        echo "Created user";
    } else {
        echo "Cannot create user";
    }
}