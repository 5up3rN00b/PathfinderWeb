<?php
//require '../templates/helper.php';

$url = "";
$data = array(
    'origins' => array(
        array(
            'latitude' => 37,
            'longitude' => -122
        ),
        array(
            'latitude' => 32,
            'longitude' => -117
        )
    ),
    'travelMode' => 'driving'
);

echo json_encode($data);