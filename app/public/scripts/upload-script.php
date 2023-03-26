<?php session_start();

  if(isset($_POST['submitValue'])){
    if($_POST['submitValue'] == 1){

      require_once 'config.php';
      require_once 'functions-scripts.php';

      $file = $_FILES['upload-photo'];
      
      $fileName = $_FILES['upload-photo']['name'];
      $fileTmpName = $_FILES['upload-photo']['tmp_name'];
      $fileSize = $_FILES['upload-photo']['size'];
      $fileError = $_FILES['upload-photo']['error'];
      $fileType = $_FILES['upload-photo']['type'];

      $delimiter = '.';
      $fileExt = explode($delimiter, $fileName);
      $fileActualExt = strtolower(end($fileExt));

      $allowed = array('jpg', 'jpeg', 'png', 'svg');
      if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
          if ($fileSize < 1000000) {
            $fileNameNew = "profile-".$_SESSION["uid"].'.'.$fileActualExt;
            $fileDestination = '../uploads/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            // setUploadedStatus($conn, $_SESSION["uid"]);
            header("Location: ../choose-profile-picture.php?error=uploadsuccess");
          } else {
            // FILE TOO BIG
          }
        } else {
        // ERROR OCCURED UPLOADING
      }
      } else {
        // FILE TYPE NOT ALLOWED
      }
    } else {
      header("Location: ../index.php?error=invalidsubmit");
      exit();
    }
  } else {
    header("Location: ../index.php?error=invalidaccess");
    exit();
  }
?>