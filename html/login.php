<?php
require '../templates/helper.php';

$json = file_get_contents('php://input');
$post = json_decode($json);
print_r($post);