<?php
require_once "config.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
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
        echo "There is a problem - please try again";
      }
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }

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

  // Check input errors before inserting in database
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

    // Prepare an insert statement
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

      // Set parameters
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Redirect to login page
        header("location: login.php");
      } else{
        echo "There is a problem - please try again";
      }
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }


  function filterEmail($field){
    // Sanitize e-mail address
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);

    // Validate e-mail address
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
      return $field;
    } else{
      return FALSE;
    }
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
  </head>

  <body>
    <div class="bgContainer">
      <div class="wrapper">
        <h2>Hackathon</h2>
        <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="post">


          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

            <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
          </div>

          <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">

            <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
            <script type="text/javascript">

function validate()
{
if (document.myForm.emailcheck.value == "")
{
alert("Please enter your Email!");
document.myForm.emailcheck.focus();
return false;
}
else
{

/*validating email with strong regular expression(regex)*/
var str=document.myForm.emailcheck.value
/* This is the regular expression string to validate the email address

Email address example : john@yahoo.com ,  john@yahoo.net.com , john.mary@yahoo.org ,

john.mary@yahoo.rediff-.org ,  john.mary@yahoo.rediff-.org.com

*/

var filter = /^([w-]+(?:.[w-]+)*)@((?:[w-]+.)*w[w-]{0,66}).([com net org]{3}(?:.[a-z]{6})?)$/i
if (!filter.test(str))
{

alert("Please enter a valid email address!")
document.myForm.emailcheck.focus();
return false;
}
if (document.myForm.msgbox.value == "")
{
alert("Please enter a message!");
document.myForm.msgbox.focus();
return false;
}
}

return(true);
}

</script>

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
            <input type="submit" class="btn btn-primary" value="Submit">


          </div>
        </form>
      </div>
    </div>
  </body>

</html>
