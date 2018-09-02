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

  </head>

  <body>
    <div class="bgContainer dashboard">
      <div class="internal_wrappper">
        <br>


        <photo_dashboard>

          <div id="add_photo">
            <h2>Add Photo</h2>
            <div id="drop_file_zone" ondrop="upload_file2(event)" ondragover="return false">
              <div id="drag_upload_file">
                <p>Add picture</p>
                <p>or</p>
                <p><input type="button" value="Select File" onclick="file_explorer2();"></p>
                <input type="file" id="selectfile">
              </div>
            </div>
          </div>
          <div>
            <h2>
              <php echo $file ?></php>
            </h2>
                    <?php 
   if ($profile_image == ""){ 
     echo" You have not set a profile image";}else{
    $file = 'images/photos/';
   
  echo "<img class='profile_image' src = $file>";
}    
    ?>
          </div>
          <div>
            <h2>
              <php echo $file ?></php>
            </h2>
                    <?php 
   if ($profile_image == ""){ 
     echo" You have not set a profile image";}else{
    $file = 'images/photos/'.$profile_image;
   
  echo "<img class='profile_image' src = $file>";
}    
    ?>
          </div>
          <div id="photos">
            <h2>Photos</h2>
        <?php 
   if ($profile_image == ""){ 
     echo" You have not set a profile image";}else{
    $file = 'images/photos/'.$profile_image;
   
  echo "<img class='profile_image' src = $file>";
}    
    ?>
          </div>
          <div>
            <h2>
              <php echo $file ?></php>
            </h2>        <?php 
   if ($profile_image == ""){ 
     echo" You have not set a profile image";}else{
    $file = 'images/photos/'.$profile_image;
   
  echo "<img class='profile_image' src = $file>";
}    
    ?>
          </div>
          <div>
            <h2>
              <php echo $file ?></php>
            </h2>        <?php 
   if ($profile_image == ""){ 
     echo" You have not set a profile image";}else{
    $file = 'images/photos/'.$profile_image;
   
  echo "<img class='profile_image' src = $file>";
}    
    ?>
          </div>

        </photo_dashboard>


      </div>
    </div>

  </body>

  </html>