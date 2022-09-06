<?php
$response = file_get_contents('https://ghibliapi.herokuapp.com/films?limit=200');

$response = json_decode($response);

$response = array_filter($response, function ($var) {return (stripos($var->title, 'Castle') !== false);  } );
$response = array_filter($response, function ($var) { return ((int) $var->running_time >= 90 &&
    (int) $var->running_time <= 120); });
print_r($response);