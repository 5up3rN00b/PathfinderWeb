<?php
require '../templates/helper.php';

$json = file_get_contents('php://input');
$post = json_decode($json);

$start = $post->start;
$end = $post->end;
$coordinates = $post->coordinates;

$origins = array();

array_push($origins, array('latitude' => $start->latitude, 'longitude' => $start->longitude));
array_push($origins, array('latitude' => $end->latitude, 'longitude' => $end->longitude));
foreach ($coordinates as $coordinate) {
    array_push($origins, array('latitude' => $coordinate->latitude, 'longitude' => $coordinate->longitude));
}

print_r($origins);

$api_key = getKeys()[1];

$url = "https://dev.virtualearth.net/REST/v1/Routes/DistanceMatrix?key=" . $api_key;
$data = array(
    'origins' => $origins,
    'travelMode' => 'driving'
);

$options = array(
    'http' => array(
        'method' => 'POST',
        'content' => json_encode($data),
        'header' => "Content-Type: application/json\r\n"
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

$ans = 1e15;
$visited = array();
$parent = array();
$parent_ans = array();
$last_index = 0;
$total = sizeof($origins);
$start = 0;
$end = 1;

for ($i = 0; $i < $total; $i++) {
    $visited[$i] = false;
    $adj[$i][$i] = 0;
}
$visited[$start] = true;

tsp($start, 0, 0);

echo $ans;

function tsp($curr, $count, $cost) {
    global $adj, $ans, $visited, $parent, $parent_ans, $total, $end;

    if ($count == $total - 2) {
        if ($cost + $adj[$curr][$end] < $ans) {
            $parent_ans = $parent;
            $ans = $cost + $adj[$curr][$end];
        }
    }

    for ($i = 0; $i < $total; $i++) {
        if ($i == $end) continue;

        if (!$visited[$i]) {
            $visited[$i] = true;
            $parent[$i] = $curr;
            tsp($i, $count + 1, $cost + $adj[$curr][$i]);
            $parent[$i] = $i;
            $visited[$i] = false;
        }
    }
}

print_r($parent_ans);
print_r($adj);