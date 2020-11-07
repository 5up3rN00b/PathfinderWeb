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
$response = json_decode(file_get_contents($url, false, $context));

$resource_sets = $response->resourceSets;
$resources = $resource_sets[0]->resources;
$results = $resources[0]->results;

$adj = array(array());

foreach ($results as $result) {
    $originIndex = $result->originIndex;
    $destinationIndex = $result->destinationIndex;
    $travelDistance = $result->traveDistance;
    $travelDuration = $result->travelDuration;

    $adj[$originIndex][$destinationIndex] = $travelDuration;
//    echo $result->originIndex . " " . $result->destinationIndex . " " . $result->travelDistance . " " . $result->travelDuration . "<br>";
}

print_r($adj);