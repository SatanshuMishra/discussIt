<?php
session_start();
require_once 'config.php';



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $current_username = $_POST['currentUsername'];
    $new_username = $_POST['newUsername'];
    $confirm_new_username = $_POST['confirmUsername'];

}

if($new_username != $confirm_new_username){
    $_SESSION['NewUserMatchError'] = "New usernames do not match. Please try again.";
    header("location: ../changeUsername.php?NewUserMatchError=".urlencode($_SESSION['NewUserMatchError']));
    exit();
}

$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $current_username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if(!$row){
    $_SESSION['currentUserIncorrect'] = "Your current username is incorrect";
    header("location: ../changeUsername.php?currentUserIncorrect=".urlencode($_SESSION['currentUserIncorrect']));
    exit();
}
$stmt = $conn->prepare("UPDATE user SET username = ? WHERE id = ?");
$stmt->bind_param("si",$new_username,$row["id"]);
$stmt->execute();

$_SESSION['Usernamesuccess'] = "Username Sucessfully Updated.";
$_SESSION["uname"] = $new_username;
header("location: ../SettingsDirectory.php?message=" . urlencode($_SESSION['Usernamesuccess']));


exit();

/*<script type = "text/javascript">
document.write('<script type = "text/javascript src = ../js/usernameUpdateSend.js"></script>');
</script>
*/
?>
