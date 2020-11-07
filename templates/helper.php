<?php

function getKeys() {
    $handle = fopen($_SERVER['DOCUMENT_ROOT'] . '/../private/keys.csv', 'r');
    return fgetcsv($handle, 5, ',');
}

function setupDb() {
    $dsn = 'mysql:host=localhost;dbname=pathfinder';
    $user = 'aaron';

    $password = getKeys()[0];

    try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        return false;
    }
}

$db = setupDb();
if (!$db) {
    die("Database could not load");
}