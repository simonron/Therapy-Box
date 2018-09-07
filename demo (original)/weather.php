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
    console.log("Latitude: " + position.coords.latitude +
      " !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Longitude: " + position.coords.longitude);
    x.innerHTML = "Latitude: " + position.coords.latitude +
      "<br>Longitude: " + position.coords.longitude;
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    jsonCoordURL = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&key=AIzaSyAco2DDdmDtvlETyITe9KvFGNDPOLFPEu4';

    place_name = getJSON(jsonCoordURL)
    console.log("~~~~~~~~~~~~~~~~~~~~~~~~place_name = " + place_name);

    return lat, lng;
  }

  getLocation();


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

  jsonURL = 'http://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=4d73012180703ba89ac49f61eb202d5f';
  resp = getJSON(jsonURL);
  geoLocation = 'Nottingham,uk';
  geo_weatherURL = 'http://api.openweathermap.org/data/2.5/weather?q=' + geoLocation + '&APPID=4d73012180703ba89ac49f61eb202d5f';

  console.log("@@@@@@ jsonURL = " + jsonURL);
  console.log("@@@@@@ geo_weather = " + geo_weatherURL);
  console.log("resp = " + resp);
  resp = getJSON(geo_weatherURL);
  console.log("resp geo_weatherURL = " + resp);
  // resp =  geo_weather;  

  console.log("json returned as > " + resp);
  var $obj = JSON.parse(resp);
  console.log(JSON.stringify($obj));
  //console.log("!!!!!!!!!!!!"+$obj.coord.lat);
  console.log("!!!!!!!!!!!!" + $obj.weather[0].description);
  
  temp = $obj.main.temp;
  tempC = temp - 273;
  console.log("!!!!!!!!!!!!" + temp);
  console.log("!!!!!!!!!!!!" + tempC);

</script>

<?php echo($data['weather'][0][description]) ?>
<?php   print_r($data); ?>
<script>
  x = 0;
  //console.log(x);
  txt = x;
  /*xmlhttp.onreadystatechange = function() {*/
  //if (this.readyState == 4 && this.status == 200) {
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
  console.log(JSON.stringify($obj));
  //txt="frog";
  document.getElementById("demo").innerHTML = txt;

  /*};*/
  //alert();

</script>
