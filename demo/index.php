       <div id="demo">change this</div>
<?php
// Destroy the session.
session_destroy();
// Unset all of the session variables

$_SESSION = array();

// Initialize the session
session_start();

// Unset all of the session variables
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Hackathon Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

  </head>

  <body>

  
   <div class="bgContainer">
       <div class="wrapper">
        <h2>Hackathon</h2>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group 
               <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="username" class="form-control" placeholder = "Username"> 
                <?php echo $username; ?>
                <span class="help-block">
                <?php echo $username_err; ?></span>
            </div>    
            <div class="form-group 
               <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" placeholder="Password"  class="form-control">
                <span class="help-block">
                <?php echo $password_err; ?></span>
            </div>
            <div class="form-group full-width">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p class= "full-width">New to Hackathon? <a href="register.php">Sign up</a>.</p>
        </form>
    </div> 
    <?php

     
     //api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=4d73012180703ba89ac49f61eb202d5f
     
    $request = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=4d73012180703ba89ac49f61eb202d5f');
     //$json=$request;
     echo"<br>NEW STUFF next";
    //$response  = file_get_contents('index.php');
          //print_r($response);
echo"<br> jsonobj output is ---";
    $jsonobj  = json_decode($request,true);
    print_r($jsonobj);
     
     
     /*$json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=4d73012180703ba89ac49f61eb202d5f');
*/
$data = json_decode($jsonobj,true);

     print_r($data);


$weather = $data['weather'][0][description];
//$temperature = $data['weather'][1]['main'][0][temp];

echo "<pre>";
echo"Weather<br>";
print_r($weather);
  
     
$bit = base;
     
$output = $data[$bit][0];
echo "<pre>";
echo $output."<br>";
//print_r($temperature);
?>

    
      <?php echo($data['weather'][0][description]) ?>
       <?php   print_r($data); ?>
       <script>
          x = 0;
           console.log(x);
        txt = x;
/*xmlhttp.onreadystatechange = function() {*/
    //if (this.readyState == 4 && this.status == 200) {
        myObj = JSON.parse(<?php echo("$data") ?>);
        
       
        //for (x in myObj) {
          //  txt += myObj[x].name + "<br>";
          
        //}
      //txt="frog";
        document.getElementById("demo").innerHTML = txt;
    
/*};*/
//alert();
     </script>

    </div>
</body>
</html>