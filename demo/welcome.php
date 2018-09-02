<?php
// Initialize the session
session_start();
require_once "config.php";

$username = htmlspecialchars($_SESSION["username"]);
//echo'<br>'+$username
 $sql = 'SELECT username, profile_image FROM users';
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
 
      if($row["username"]===$username){$profile_image = $row["profile_image"];}
    }
} 

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
     
     
      <h1>Good day <b><?php echo $username ?></b></h1>

      <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
      </p>
      
      
    </div>
  <?php 
    $file = 'images/profiles/'.$profile_image;
    if (file_exists($file)); { 
  echo "<img src = $file style='width:40vw'>;";
}    
    ?>
                                                                        
  </body>

  </html>