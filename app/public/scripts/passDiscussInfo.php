<?php session_start();

if(isset($_POST['submit'])){
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['content'];
    $_SESSION['postTitle'] = $postTitle;
    $_SESSION['content'] = $postContent;

    header("Location: ../reviewpost.php");

}

?>