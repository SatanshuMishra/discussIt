<?php session_start();
  if(!isset($_SESSION["uid"])){
    header("location: index.php?error=usernotloggedin");;
  }
?>
<!DOCTYPE html>
<html>
<head>        
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="css/colourscheme.css">
    <!-- LOCAL JS -->
    <script src="js/welcome.js"></script>
    <!-- HEADER INCLUDE -->
    <?php include_once "./includes/header-information.php"; ?>
    <title>Change Colour Scheme</title>
</head>
<body>
    <?php include 'components/navigation-bar-v2-no-search.php'; ?>
    <h1>Change Colour Scheme</h1>
    <div class = "light">
        <h2>Light Scheme</div>

    </div>
    <div class = "dark">
        <h2>Dark Scheme</div>
    </div>
    
  <?php include_once "./components/footer.php"; ?>
</body>
</html>