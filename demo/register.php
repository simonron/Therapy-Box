<?php
session_start();
$profile_image=$_SESSION["profile_image"]; 
$_SESSION["upload_target"] = 'profiles';
require_once "config.php";
echo"<h1>$profile_image</h1>";

if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
  } else{
    $sql = "SELECT id FROM users WHERE username = ?";

    if($stmt = mysqli_prepare($link, $sql)){
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      $param_username = trim($_POST["username"]);

      if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
          $username_err = "This username is already taken.";
        } else{
          $username = trim($_POST["username"]);
        }
      } else{
        echo "There is a database problem - please try again";
      }
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }
$profile_image = $_SESSION['profile_image'];

  // Validate password
  if(empty(trim($_POST["password"]))){
    $password_err = "Please enter a password.";     
  } elseif(strlen(trim($_POST["password"])) < 6){
    $password_err = "Password must have atleast 6 characters.";
  } else{
    $password = trim($_POST["password"]);
  }

  // Validate confirm password
  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = "Please confirm password.";     
  } else{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
      $confirm_password_err = "Password did not match.";
    }
  }
  // Validate email
  if(empty(trim($_POST["email"]))){
    $email_err = "Please enter an email address.";     
  } elseif(strlen(trim($_POST["email"])) < 6){
    $email_err = "email must be valid";
  } else{
    $email = trim($_POST["email"]);
  }
  


  // Check input errors before inserting in database
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
    /*if (!isset($profile_image) || ($profile_image === "" )){
      $profile_image="no avatar uploaded";
    //$profile_image=""; 
    }*/
    
    //$email ="a sock";
    $param_profileimage = $profile_image; 
    $param_email = $email;
    //$username ="give it a go3";
    /*if($profile_image == "" ){$profile_image="no avatar uploaded";}*/
      // Prepare an insert statement
      $sql = "INSERT INTO users (username, password, profile_image, email) VALUES (?,?,?,?)";

    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_profileimage,  $param_email);

      // Set parameters
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
      $param_email = $email;
      

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Redirect to index login page

       echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
        exit();
    }else{
        echo "There is a problem - can't find a file - please try again";
      }
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }


     // Close connection
     mysqli_close($link);
     }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Register</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
      <link rel="stylesheet" href="css/style.css">
      <script type="text/javascript" src="js/jquery.js"></script>
      <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/image_upload_script.js"></script>

    </head>

    <body>
      <div class="bgContainer">
        <div class="wrapper">
          <h2>Hackathon</h2>
          <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="post" ;>


            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

              <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
              <span class="help-block"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">

              <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
              <span class="help-block "><?php echo $email_err; ?></span>
            </div>


            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>">
              <span class="help-block"><?php echo $password_err; ?></span>
            </div>


            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
              <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" value="<?php echo $confirm_password; ?>">
              <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group full-width">
              <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
                <div id="drag_upload_file">
                  <p>Add picture</p>
                  <p>or</p>
                  <p><input type="button" value="Select File" onclick="file_explorer();"></p>
                  <input type="file" id="selectfile">
                </div>

              </div>
            </div>
            <div class="form-group full-width">
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
          </form>
        </div>
      </div>
        <p class= "full-width info">Return <a href="index.php">to login page </a>.</p>
    </body>

    </html>