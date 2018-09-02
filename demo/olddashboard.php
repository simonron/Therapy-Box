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
    <title>Dashboard</title>


    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


    <link rel="stylesheet" href="css/style.css">

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
            <h2>Photos</h2>
            <?php include 'photos.php';?>
          
          </div>
          <div>
            <h2>Tasks</h2>
          </div>
          <div>
            <h2>Clothes</h2>
          </div>

        </dashboard>





        <script>
          getLocation();

          function getLocation() {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPosition);
            } else {
              x.innerHTML = "Geolocation is not supported by this browser.";
            }
          }

          function showPosition(position) {
            //var test_display = document.getElementById("test_display");
            ////console.log("Latitude: " + position.coords.latitude + !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Longitude: " + position.coords.longitude);
            //test_display.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            jsonCoordURL = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&key=AIzaSyAco2DDdmDtvlETyITe9KvFGNDPOLFPEu4';
            //console.log("jsonCoordURL = " + jsonCoordURL);
            json_geo_list = getJSON(jsonCoordURL)
            //console.log("~~~~~~~~~~~~~~~~~~~~~~~~json_geo_list = " + json_geo_list);
            var $obj = JSON.parse(json_geo_list);

            x = 0;
            ////console.log(x);
            txt = x;
            /*xmlhttp.onreadystatechange = function() {*/
            //if (this.readyState == 4 && this.status == 200) {
            myObj = $obj;


            for (x in myObj) {
              txt += myObj[x] + "<br>"
              for (y in myObj[x]) {;
                txt += myObj[x][y] + "<br>"
                for (z in myObj[x][y]) {;
                  txt += myObj[x][y][z] + "<br>"
                }
              }
            }

            //console.log(JSON.stringify($obj));
            //txt="frog";
            //document.getElementById("demo").innerHTML = txt;

            //console.log("!!!!!!!!!!!!" + $obj.results[0].address_components[3].short_name);
            geoLocation = $obj.results[0].address_components[3].short_name; //CITY!!
            document.getElementById("city").innerHTML = geoLocation;

            $city = geoLocation;

            geo_weatherURL = 'http://api.openweathermap.org/data/2.5/weather?q=' + geoLocation + '&APPID=4d73012180703ba89ac49f61eb202d5f';
            resp = getJSON(geo_weatherURL);
            //console.log("resp geo_weatherURL = " + resp);
            // resp =  geo_weather;  

            //console.log("json returned as > " + resp);
            var $obj = JSON.parse(resp);
            //console.log(JSON.stringify($obj));
            ////console.log("!!!!!!!!!!!!"+$obj.coord.lat);
            //console.log("!!!!!!!!!!!!" + $obj.weather[0].description);

            weather_symbol_code = $obj.weather[0].description;
            icon = weather_symbol(weather_symbol_code);
            //console.log("icon = " + icon);
            document.getElementById("weather_condition").innerHTML = "<img src=" + icon + ">";



            temp = $obj.main.temp;
            tempC = temp - 273;
            document.getElementById("temp").innerHTML = tempC.toFixed(1) + " degrees";
            //console.log("!!!!!!!!!!!!" + temp);
            //console.log("!!!!!!!!!!!!" + tempC);

            /*   temp = $obj.main.temp;
               tempC = temp - 273;
               //console.log("!!!!!!!!!!!!" + temp);
               //console.log("!!!!!!!!!!!!" + tempC);*/




            return lat, lng;
          }


          function getJSON(url) {
            var resp;
            var xmlHttp;

            resp = '';
            xmlHttp = new XMLHttpRequest();

            if (xmlHttp != null) {
              xmlHttp.open("GET", url, false);
              xmlHttp.send(null);
              resp = xmlHttp.responseText;
            }
            return resp;
          }


          function alldone($obj) {
            //console.log("!!!!!!!!!!!!" + $obj.weather[0].description);
            temp = $obj.main.temp;
            tempC = temp - 273;
            //console.log("!!!!!!!!!!!!" + temp);
            //console.log("!!!!!!!!!!!!" + tempC);
          }

          function weather_symbol(symbol) {
            //console.log("symbol at func =" + symbol);
            switch (symbol) {
              case 'clear sky':
                icon = icon('01d');
                return icon;
                break;
              case 'few clouds':
                icon = icon('02d');
                return icon;
                break;
              case 'scattered clouds':
                icon = icon('03d');
                return icon;
                break;
              case 'broken clouds':
                icon = icon('04d');
                return icon;
                break;
              case 'shower rain':
                icon = icon('09d');
                return icon;
                break;
              case 'rain':
                icon = icon('10d');
                return icon;
                break;
              case 'thunderstorm':
                icon = icon('11d');
                return icon;
                break;
              case 'snow':
                icon = icon('13d');
                return icon;
                break;
              case 'mist':
                icon = icon('50d');
                return icon;
                break;
              default:
                icon = "no idea";
                return icon;
                break;
            }

            function icon(code) {
              //console.log("code at func icon = " + code);
              icon = "http://openweathermap.org/img/w/" + code + ".png";
              return icon;
            }

          }
        </script>
      </div>
    </div>

  </body>

  </html>