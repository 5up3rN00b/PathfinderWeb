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

$ans = 10000000000000000000;
$visited = array();
$total = 2;
$end = 0;

for ($i = 0; $i < $total; $i++) $visited[$i] = false;
$visited[0] = true;

tsp(0, 0, 0);

echo $ans;

function tsp($curr, $count, $cost) {
    global $adj, $ans, $visited, $total, $end;

    if ($count == $total) {
        $ans = min($ans, $cost + $adj[$curr][$end]);
    }

    for ($i = 0; $i < $total; $i++) {
        if (!$visited[$i]) {
            $visited[$i] = true;
            tsp($i, $count + 1, $cost + $adj[$curr][$i]);
            $visited[$i] = false;
        }
    }
}

print_r($adj);