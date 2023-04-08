<?php 
session_start();
$createdAt =  $_GET["timestamp"];
$currentTime = time();
$timeSincePost = $currentTime - $createdAt;

if ($timeSincePost < 60) {
    $timeReturned = 'Posted just now';
} elseif ($timeSincePost < 3600) {
    $minutes = floor($timeSincePost/60);
    $timeReturned = $minutes == 1 ? '1 minute ago' : $minutes.' minutes ago';
} elseif ($timeSincePost < 86400) {
    $hours = floor($timeSincePost/3600);
    $timeReturned = $hours == 1 ? '1 hour ago' : $hours.' hours ago';
} else {
    $days = floor($timeSincePost/86400);
    $timeReturned = $days == 1 ? '1 day ago' : $days.' days ago';
}

echo $timeReturned;
?>





