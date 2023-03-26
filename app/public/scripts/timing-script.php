<?php session_start();
$createdAt =  $_GET["timestamp"];
$currentTime = time();
$timeSincePost = $currentTime - (int)$createdAt;


if($timeSincePost < 60){
    $timeReturned = 'Less than a minute ago';
}elseif($timeSincePost < 3600){
    $timeReturned = floor($timeSincePost/60).' minutes ago';
}elseif($timeSincePost < 86400) {
    $timeReturned = floor($timeSincePost/3600).' hours ago';

}elseif(intval(floor($timeSincePost/86400)) == 1) {
    $timeReturned = floor($timeSincePost/86400).' day ago';
}elseif(floor($timeSincePost/86400) > 1){
    $timeReturned = floor($timeSincePost/86400).' days ago';
}

echo $timeReturned;

?>