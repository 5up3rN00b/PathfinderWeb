<?php
function setupDb() {
    $dsn = 'mysql:host=localhost;dbname=pathfinder';
    $user = 'aaron';

    $handle = fopen($_SERVER['DOCUMENT_ROOT'] . '/../private/keys.csv', 'r');
    $data = fgetcsv($handle, 5, ',');
    $password = $data[0];

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