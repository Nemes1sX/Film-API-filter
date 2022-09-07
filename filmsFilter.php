<?php

function startsWith($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function filterWithStartAndEndRunningTimeIntervals($response)
{
    $filmRunningTimeStartInterval = (int) $_GET['filmRunningTimeStartInterval'];
    $filmRunningTimeEndInterval = (int) $_GET['filmRunningTimeEndInterval'];
    if ($filmRunningTimeStartInterval > $filmRunningTimeEndInterval) {
        $filmRunningTimeEndInterval = $filmRunningTimeStartInterval + $filmRunningTimeEndInterval;
        $filmRunningTimeStartInterval = $filmRunningTimeEndInterval - $filmRunningTimeStartInterval;
        $filmRunningTimeEndInterval = $filmRunningTimeEndInterval - $filmRunningTimeStartInterval;
    }
    return array_filter($response, function ($var) use ($filmRunningTimeStartInterval, $filmRunningTimeEndInterval) {
        return ((int)$var->running_time >= $filmRunningTimeStartInterval &&
            (int)$var->running_time <= $filmRunningTimeEndInterval);
    });
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
if (strlen($_GET['filmRunningTimeStartInterval']) > 0 && $_GET['filmRunningTimeStartInterval'] != '' &&
    strlen($_GET['filmRunningTimeEndInterval']) > 0 && $_GET['filmRunningTimeEndInterval'] != '') {
    $response = filterWithStartAndEndRunningTimeIntervals($response);
}
elseif (strlen($_GET['filmRunningTimeStartInterval']) > 0 && $_GET['filmRunningTimeStartInterval'] != '' ) {
    $filmRunningTimeStartInterval = (int) $_GET['filmRunningTimeStartInterval'];
    $response = array_filter($response, function ($var) use ($filmRunningTimeStartInterval) {
        return ((int)$var->running_time >= $filmRunningTimeStartInterval);
    });
}
elseif (strlen($_GET['filmRunningTimeEndInterval']) > 0 && $_GET['filmRunningTimeEndInterval'] != '' ) {
    $filmRunningTimeEndInterval = (int) $_GET['filmRunningTimeEndInterval'];
    $response = array_filter($response, function ($var) use ($filmRunningTimeEndInterval) {
        return ((int)$var->running_time <= $filmRunningTimeEndInterval);
    });
}

echo json_encode($response);