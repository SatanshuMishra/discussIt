<?php
session_start();
require_once 'config.php';
require_once 'functions-scripts.php';

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmedPassword = $_POST['confirmPassword'];
    $username = $_POST['username'];
}

if($newPassword != $confirmedPassword){
    $_SESSION['NewPassMatchError'] = "Your new password does not match. Please try again.";
    header("location: ../changePassword.php?NewPassMatchError=".urlencode($_SESSION['NewPassMatchError']));
    exit();
}


/*if(!CurrentPasswordMatch($conn,$currentPassword,$username)){
    $_SESSION['currentPassIncorrect'] = "Your current password is incorrect";
    header("location: ../changePassword.php?currentPassIncorrect=".urlencode($_SESSION['currentPassIncorrect']));
    exit();
}else {
    $matchedRow = $_SESSION['Row'];
    $newPasswordHashed = password_hash($newPassword,PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
    $stmt->bind_param("si",$newPassword,$matchedRow["id"]);
    $stmt->execute();
    $_SESSION['Passwordsuccess'] = "Password Sucessfully Updated.";
    header("location: ../SettingsDirectory.php?PasswordSucess=" . urlencode($_SESSION['Passwordsuccess']));
    exit();
}
*/
if(!CurrentPasswordMatch($conn,$currentPassword,$username)){
    $_SESSION['currentPassIncorrect'] = "Your current password is incorrect";
    header("location: ../changePassword.php?currentPassIncorrect=".urlencode($_SESSION['currentPassIncorrect']));
    exit();
}else{
    $userchangedpwd = $_SESSION["User"];
    $newPasswordHashed = password_hash($newPassword,PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
    $stmt->bind_param("ss",$newPasswordHashed,$userchangedpwd);
    $stmt->execute();
    $_SESSION['Passwordsuccess'] = "Password Sucessfully Updated.";
    header("location: ../SettingsDirectory.php?PasswordSucess=" . urlencode($_SESSION['Passwordsuccess']));
    exit();

}




?>