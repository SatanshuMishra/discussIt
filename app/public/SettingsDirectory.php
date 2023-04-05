<?php session_start();
if(isset($_GET['message'])){
    $usernameMSG = $_GET['message'];
    echo "<script>alert('$usernameMSG')</script>";
}
if(isset($_GET['Passwordsuccess'])){
    $passwordMSG = $_GET['Passwordsuccess'];
    echo"<script>alert('$passwordMSG')</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/settingsDirectory.css">
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Account Settings</title>
</head>
<body>
    <element id="reference-element"></element>
    <?php include 'components/navigation-bar-v2-no-search.php'; ?>

<div class = container>
    
    <div class = inside id = right>
        <img src = "images/accountsettings.jpeg">

    </div>
    <div class = inside id = left>
        <div class = "Settings-header">
         <h1>Account Settings</h1>
        <ul>
            <li><button><a href = "changeUsername.php">Change Username</a></button></li>
            <li><button><a href = "changePassword.php">Change Password</a></button></li>
            <li><button><a href = "colourscheme.php">Colour Scheme</a></button></li>
            <li><button><a href = "generateKey.php">Generate New Recovery Key</a></button></li>
            <li><button><a href = "#">Logout</a></button></li>
            <li><button id = "return-btn"><a href = "index.php">Return To Home</a></button></li>
        </ul>
</div>
    </div>
</div>


 <?php include_once "./components/footer.php"; ?>
</body>
</html>
