<?php session_start();
require_once "config.php";
require_once "functions-scripts.php";
if(isset($_POST['submit'])){
    $postTitle = $_POST['title'];
    $postContent = $_POST['content'];
    $topicsArray = $_SESSION['topics'];
    $postCreator = $_SESSION['uname'];
    if(count($topicsArray) > 0){
        $topic1 = $topicsArray[0];
    }
    if(count($topicsArray) >1){
        $topic2 = $topicsArray[1];
    }


    createPost($conn, $postContent,$postTitle,$topic1,$topic2,$postCreator);
    header("location: ../index.php?message=postsuccess");


}

?>