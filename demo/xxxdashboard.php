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

include('header.php')
?>
 <script type="text/javascript" src="js/photo_script.js"></script>
  <script type="text/javascript" src="js/weather_script.js"></script>

  </head>


  <body>
    <div class="bgContainer dashboard">
      <div class="internal_wrappper">
        <br>


        <h1>Good day <b><?php echo $username ?></b></h1>
        <!--<i class="wi wi-night-sleet"></i>
-->
        <p>
          <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
          <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </p>



        <?php 
   if ($profile_image == ""){ 
     echo" You have not set a profile image";}else{
    $file = 'images/profiles/'.$profile_image;
   
  echo "<img class='profile_image' src = $file>";
}    
    ?>
        <dashboard>

          <div id="weather">
            <h2>Weather</h2>
            <div id="city">your current location</div>
            <div id="temp"> Current Temperature</div>
            <div id="weather_condition"> Weather icon</div>
          </div>
          <div>
            <h2>News</h2>
          </div>
          <div>
            <h2>Sport</h2>
          </div>
          <div id="photos">
            <a href="photo_dashboard.php">
              <h2>Photos</h2>
              <?php include 'photos.php';?>
            </a>
          </div>
          <div>
            <h2>Tasks</h2>
          </div>
          <div>
            <h2>Clothes</h2>
          </div>

        </dashboard>




      </div>
    </div>

  </body>

  </html>
