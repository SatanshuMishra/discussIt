<?php session_start();
$createdAt =  $_GET["timestamp"];
$timezone = date_default_timezone_set('UTC');
$createdAt = strtotime($createdAt);
$currentTime = time();

$timeSincePost = $currentTime - $createdAt-43200;


if($timeSincePost < 60){
    $timeReturned = 'Less than a minute ago';
}elseif($timeSincePost < 3600){
    $timeReturned = floor($timeSincePost/60).' minutes ago';
}elseif($timeSincePost < 8600 && floor($timeSincePost/3600) ==1) {
    $timeReturned = floor($timeSincePost/3600).' hour ago';
}elseif($timeSincePost < 8600 && floor($timeSincePost/3600) >1) {
    $timeReturned = floor($timeSincePost/3600).' hours ago';
}elseif(intval(floor($timeSincePost/86400)) == 1) {
    $timeReturned = floor($timeSincePost/86400).' day ago';
}elseif(floor($timeSincePost/86400) > 1){
    $timeReturned = floor($timeSincePost/86400).' days ago';
}

echo $timeReturned;
?>