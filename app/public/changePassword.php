<?php session_start();?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!-- CSS -->
       <link rel="stylesheet" href="css/changePassword.css">
        <!-- Script -->
        <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
        <title>Change Password</title>

</head>

<body>
    <?php include 'components/navigation-bar-v2-no-search.php'; ?>
        <h1>Change Password</h1>
    <div class = container>
        <div class = inside id = right>
            <div class = "background">
                <img src = '../images/undraw_authentication_re_svpt.svg' class = passimg>
         </div>
        </div>
        <div class = inside id = left>
            <form action = "scripts/changePassword-script.php" method = "POST">
                <label for = "username">Username</label>
                <input type="text" id = "username" name = "username" required><br>
                <label for = "currentPassword">Previous Pasword:</label>
                <input type = "text" id = "currentPassword" name = "currentPassword" required><br>

                <label for = "newPassword">New Password:</label>
                <input type = "text" id = "newPassword" name = "newPassword" required><br>

                <label for = "confirmNewUsername">Confirm New Password:</label>
                <input type = "text" id = "confirmPassword" name = "confirmPassword" required><br>
                <input type = "submit" value = "Submit">
                <button id = "cancel-btn"><a href = "settingsDirectory.php">Cancel</a></button>
            </form>
            
                
        </div>
    </div>



</body>
</html>