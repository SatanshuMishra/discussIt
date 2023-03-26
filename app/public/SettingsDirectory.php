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
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!-- CSS -->
       <link rel="stylesheet" href="css/settingsDirectory.css">
        <!-- Script -->
        <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
        <title>Account Settings</title>

</head>
<body>
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
            <li><button><a href = "#">Discussion Post History</a></button></li>
            <li><button><a href = "#">Generate New Recovery Key</a></button></li>
            <li><button><a href = "#">Logout</a></button></li>
            <li><button id = "return-btn"><a href = "index.php">Return To Home</a></button></li>
        </ul>
</div>
    </div>
</div>



</body>

<html>
