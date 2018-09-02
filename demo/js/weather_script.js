/*****************Weather code***************/

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
            // icon test geoLocation ="London";
            $city = geoLocation;

            geo_weatherURL = 'http://api.openweathermap.org/data/2.5/weather?q=' + geoLocation + '&APPID=4d73012180703ba89ac49f61eb202d5f';
            resp = getJSON(geo_weatherURL);

            var $obj = JSON.parse(resp);
  
            weather_symbol_code = $obj.weather[0].description;
            icon = weather_symbol(weather_symbol_code);
          
           if (icon == weather_symbol_code) {document.getElementById("weather_condition").innerHTML = weather_symbol_code+"<br>(no icon)"; }else{document.getElementById("weather_condition").innerHTML = "<img src=" + icon + ">";}



            temp = $obj.main.temp;
            tempC = temp - 273;
            document.getElementById("temp").innerHTML = tempC.toFixed(1) + " degrees";

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
                icon = symbol
                return icon;
                break;
            }

            function icon(code) {
              //console.log("code at func icon = " + code);
              icon = "http://openweathermap.org/img/w/" + code + ".png";

              return icon;
            }


          }

/********************************************/
