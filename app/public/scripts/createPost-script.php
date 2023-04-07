<?php session_start();
require_once "config.php";
require_once "functions-scripts.php";
if(isset($_POST['submit'])){
    $postTitle = $_POST['title'];
    $postContent = $_POST['content'];
    $topicsArray = $_SESSION['topics'];
    $postCreator = $_SESSION['uname'];
    $numberOfTopics = sizeof($topicsArray);
   
    if($numberOfTopics > 1){
        $topic1 = $topicsArray[0];
        $topic2 = $topicsArray[1];
    } else {
        $topic1 = $topicsArray[0];
        $topic2 = null;
    }

    if($discussionId = createPost($conn, $postContent,$postTitle,$topic1,$topic2,$postCreator)){
        header("location: ../discussion.php?id=$discussionId&message=postSuccessfullyCreated");
        exit();
    } else {
        header("location: ../index.php?error=errorOccured");
        exit();
    }
    

}

?>
