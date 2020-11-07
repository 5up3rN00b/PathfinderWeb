<?php
require '../templates/helper.php';

$api_key = getKeys()[1];

$url = "https://dev.virtualearth.net/REST/v1/Routes/DistanceMatrix?key=" . $api_key;
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

$options = array(
    'http' => array(
        'method'  => 'POST',
        'content' => json_encode($data),
        'header' =>  "Content-Type: application/json\r\n"
    )
);

$context = stream_context_create($options);
$result = json_decode(file_get_contents($url, false, $context));

print_r($result->{'results'});