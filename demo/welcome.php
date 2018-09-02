<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
echo "got this far";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Welcome</title>


    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

  </head>

  <body>
   <div class= "internal_wrappper">
<br>
      <h1>Good day <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>

      <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
      </p>
      <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
        <div id="drag_upload_file">
          <p>Drop a profile image file here</p>
          <p>or</p>
          <p><input type="button" value="Select File" onclick="file_explorer();"></p>
          <input type="file" id="selectfile">
        </div>

    </div>
    
<!--   <?php if(file_exists ( $profile_image )){
  echo '<img src = images/$profile_image class = "profile_image">';};
  ?>-->

    </div>
  </body>

  </html>