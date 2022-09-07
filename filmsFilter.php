<?php

function startsWith($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

$response = file_get_contents('https://ghibliapi.herokuapp.com/films?limit=200');

$response = json_decode($response);

if (strlen($_GET['filmTitle']) > 0 && $_GET['filmTitle'] != '') {
    $filmTitle = $_GET['filmTitle'];
    $response = array_filter($response,
        function ($var) use ($filmTitle) {
            return (startsWith($var->title, $filmTitle) == true);
    }
    );
}

$response = array_filter($response, function ($var) { return ((int) $var->running_time >= 90 &&
    (int) $var->running_time <= 130); });

echo json_encode($response);