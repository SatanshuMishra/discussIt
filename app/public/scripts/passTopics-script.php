<?php session_start();
$selectedTopics = array();
if(isset($_POST['submit'])){
    if(isset($_POST['topicsArray'])){
        $selectedTopics = $_POST['topicsArray'];
        $_SESSION['selectedTopics'] = $selectedTopics;
        
        
    }
}
header("Location: ../Creatediscussion(2).php");
exit();

?>
