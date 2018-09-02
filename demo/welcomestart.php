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
    <div class="bgContainer">
      <div class="internal_wrappper">
        <br>


        <h1>Good day <b><?php echo $username ?></b></h1>

        <p>
          <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
          <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </p>


      </div>
      <?php 
   if ($profile_image == ""){ 
     echo" You have not set a profile image";}else{
    $file = 'images/profiles/'.$profile_image;
   
  echo "<img src = $file style='width:40vw'>;";
}    
    ?>
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      <div id="demo">change this</div>  
           <div id="demo2">change this</div>   
         <script>
           
         
var x = document.getElementById("demo2");
           
       
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }

}
function showPosition(position) {
    //console.log("Latitude: " + position.coords.latitude + 
    //" !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Longitude: " + position.coords.longitude); 
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude; 
 var lat = position.coords.latitude;
var  lng = position.coords.longitude;
  jsonCoordURL = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&key=AIzaSyAco2DDdmDtvlETyITe9KvFGNDPOLFPEu4';
        console.log("!!!!!!!!!!!!jsonCoordURL "+jsonCoordURL );

  geo_weatherURL='http://api.openweathermap.org/data/2.5/weather?q='+jsonCoordURL+'&APPID=4d73012180703ba89ac49f61eb202d5f';   
          console.log("!!!!!!!!!!!geo_weatherURL "+geo_weatherURL );


  place_name = getJSON(geo_weatherURL)
    //resp = getJSON(geo_weatherURL) ;
      // console.log("resp geo_weatherURL = "+resp);
 // resp =  geo_weather;  
      
       //console.log("json returned as > "+resp);
      var $obj = JSON.parse(place_name);
      console.log(JSON.stringify($obj));
      //console.log("!!!!!!!!!!!!"+$obj.coord.lat);
      console.log("!!!!!!!!!!!!"+$obj.weather[0].description);
      temp = $obj.main.temp;
      tempC = temp-273;
      console.log("!!!!!!!!!!!!"+temp);
      console.log("!!!!!!!!!!!!"+tempC);

//console.log("~~~~~~~~~~~~~~~~~~~~~~~~place_name = "+ place_name);
     
  return lat,lng;
}
           
             getLocation();
           

   function getJSON(url) {
        var resp ;
        var xmlHttp ;

        resp  = '' ;
        xmlHttp = new XMLHttpRequest();

        if(xmlHttp != null)
        {
            xmlHttp.open( "GET", url, false );
            xmlHttp.send( null );
            resp = xmlHttp.responseText;
        }
        return resp ;
    }
      
//jsonURL = 'http://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=4d73012180703ba89ac49f61eb202d5f';
//resp = getJSON(jsonURL) ;
//geoLocation='Nottingham,uk';

/*
      
    //console.log("@@@@@@ jsonURL = "+jsonURL);
      //console.log("@@@@@@ geo_weather = "+geo_weatherURL);
      //console.log("resp = "+resp);
      resp = getJSON(geo_weatherURL) ;
       console.log("resp geo_weatherURL = "+resp);
 // resp =  geo_weather;  
      
       console.log("json returned as > "+resp);
      var $obj = JSON.parse(resp);
      console.log(JSON.stringify($obj));
      //console.log("!!!!!!!!!!!!"+$obj.coord.lat);
      console.log("!!!!!!!!!!!!"+$obj.weather[0].description);
      temp = $obj.main.temp;
      tempC = temp-273;
      console.log("!!!!!!!!!!!!"+temp);
      console.log("!!!!!!!!!!!!"+tempC);
*/


     </script>
    
     
       <script>
          x = 0;
           //console.log(x);
        txt = x;

        myObj = JSON.parse(resp);
        
       
        for (x in myObj) {
            txt += myObj[x] + "<br>"
          for (y in myObj[x]) {;
          txt += myObj[x][y] + "<br>"
                   for (z in myObj[x][y]) {;
          txt += myObj[x][y][z] + "<br>"                  
                              }
                              }
          
        }
/*
         console.log(JSON.stringify($obj));

        document.getElementById("demo").innerHTML = txt;
*/

     </script>

    
    
    
    
    
    
    
    
    
    
  </body>

  </html>
