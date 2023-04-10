<?php session_start();
  if(!isset($_SESSION["uid"])){
    header("location: ../index.php?error=notloggedin");
    exit();
  }
  require_once "./includes/functions.php";
  $user = getUserByID($conn, $_SESSION["uid"]);
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

        <div class="container">
            <div class="header">
                <h1>Settings</h1>
            </div>
            <div class="body">
                <div class="left-column">
                    <div class="personal-info-form form-container">
                        <form action="./scripts/settings-update-personal.php" method="post">
                            <h1>Personal Information</h1>
                            <input type="hidden" name="userId" value="<?php echo $_SESSION["uid"] ?>">
                            <label class="input-label" for="firstname">First Name</label>
                            <input class="input-field" type="text" name="firstname" id="firstname" value="<?php echo $user['firstName'] ?>">
                            <label class="input-label" for="lastname">Last Name</label>
                            <input class="input-field" type="text" name="lastname" id="lastname" value="<?php echo $user['lastName'] ?>">
                            <div class="submit-container">
                                <button class="style-button" name="submit" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="connections-form form-container">
                        <form action="#" method="post">
                            <h1>Connections</h1>
                            <input type="hidden" name="userId" value="<?php echo $_SESSION["uid"] ?>">
                            <label class="input-label" for="twitter">Twitter</label>
                            <input class="input-field" type="text" name="twitter" id="twitter" value="<?php echo $user['twitterAccount'] ?>">
                            <label class="input-label" for="linkedin">LinkedIn</label>
                            <input class="input-field" type="text" name="linkedin" id="linkedin" value="<?php echo $user['linkedinAccount'] ?>">
                            <label class="input-label" for="pg-web">Personal Website</label>
                            <input class="input-field" type="text" name="pg-web" id="pg-web" value="<?php echo $user['pgwebAddress'] ?>">
                            <div class="submit-container">
                                <button class="disabled style-button" name="submit" type="button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="right-column">
                    <div class="change-username-container link-container">
                        <h1>Change Username</h1>
                        <a href="./changeUsername.php">
                            <button class="style-button">Proceed</button>
                        </a>
                    </div>
                    <div class="change-password-container link-container">
                        <h1>Change Password</h1>
                        <a href="./changePassword.php">
                            <button class="style-button">Proceed</button>
                        </a>
                    </div>
                    <div class="generate-key-container link-container">
                        <h1>Generate New Recovery Key</h1>
                        <a class="disabled">
                            <button class="disabled style-button">Proceed</button>
                        </a>
                    </div>
                    <div class="bio-form form-container">
                        <form action="#" method="post">
                            <h1>Biography</h1>
                            <input type="hidden" name="userId" value="<?php echo $_SESSION["uid"] ?>">
                            <textarea name="bio" rows="1" placeholder="<?php echo $user['biography'] ?>"></textarea>
                            <div class="submit-container">
                                <button class="disabled style-button" name="submit" type="button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "./components/footer.php"; ?>
    </body>
</html>
