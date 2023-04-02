<?php session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['search-string'])){
      require_once 'config.php';
      require_once 'functions-scripts.php';

      $_SESSION['search-string'] = $_POST['search-string'];
      header("Location: ../searchresults.php");
      exit();
      
    } else {
        $url = $_SERVER["HTTP_REFERER"];
        header("location: $url?error=invalidsearchrequest");
        exit();
    }
  } else {
      $url = $_SERVER["HTTP_REFERER"];
      header("location: $url?error=invalidsearchrequest");
      exit();
  }
?>