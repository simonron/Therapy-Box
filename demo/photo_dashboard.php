<?php
// Initialize the session
session_start();
$_SESSION["upload_target"] = 'photos';

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
<script type="text/javascript" src="js/image_upload_script.js"></script>

</head>

<body>
  <div class="photo_dashboard bgContainer">
    <div class="internal_wrappper">
      <br>

      <div id="add_photo">
        <h2>Add Photo</h2>
        <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
          <?  $file = 'images/photos/'.$photo; ?>
          <div id="drag_upload_file">
            <p>Add picture</p>
            <p>or</p>
            <p><input type="button" value="Select File" onclick="file_explorer();"></p>

            <input type="file" id="selectfile">
          </div>
        </div>
      </div>

      <div class="columns box">
        <? $colcount = 1;
        while($colcount <= 4) {
          echo "
                  <div class='column'>
                  <div class='slide_column col_$colcount'>
                  <div class='slide container".$colcount."'>
                  STUFF HERE</div></div>
                  </div>";
          $colcount++;
        } ?> 
        <div class="column">     
          <div class="slide_column col_1">
            <? $dir="images/photos/"; $handle=opendir($dir);        

            $count =0; $colcount=1;
            while ($file = readdir($handle)) {
              if ($file<>".") {
                if ($file<>".."){
                  if ($file<>".DS_Store"){
                    $count+=1;
                    $slide="$file";
                    echo "<div class='slide container".$count."'>";
                    echo  "<img src='images/photos/".$slide."'>";
                    echo "</div>";
                    if($count%5 == 0){
                      $colcount+=1;
                      echo(" </div></div>       
                  <div class='column'>
                  <div class='slide_column col_$colcount'>");
                    }
                  }
                }
              }
            }
          
            closedir($handle);
            ?>
          </div>
        </div>
      </div>

      </photo_dashboard>
    <script>
      // TILT action code
      var gama = null;
      var zone = null;
      var ipad = "false";
      var number_of_slides = <?php echo $count ?>;
      var O = 0;
      var pitch = 0;
      var x = 0;
      var y = 0;
      var avex = 0;
      var totalx = 0;
      var flicker = 25;
      var tilt = 0;
      var gamma = null;
      var Opacity = null;
      var range = null;
      var mobileRange = null;
      var $Opacity = null;
      var smoothness = 4;
      var averageOf = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      var autoPos = 100;
      var Target = 1000;
      var fadeDir = 1;
      var Mpos = 0;
      init();

      function init() {
        //alert("init");
        O = window.orientation;
        //alert(O);
        var dataContainerOrientation = document.getElementById('dataContainerOrientation');
        var dataContainerMotion = document.getElementById('dataContainerMotion');
        if (window.DeviceOrientationEvent) {
          window.addEventListener('deviceorientation', function(event) {
            var alpha = event.alpha;
            var beta = event.beta;
            if (alpha != null || beta != null || gamma != null)
              dataContainerOrientation.innerHTML = '<strong>Orientation</strong><br />alpha: ' + alpha + '<br/>beta: ' + beta + '<br />gamma: ' + gamma;
          }, false);
        }
      }
      if (window.DeviceMotionEvent) {
        window.addEventListener("orientationchange", function() {
          O = window.orientation;
        }, false);
        window.addEventListener('devicemotion', function(event) {
          if (event.accelerationIncludingGravity) {
            x = event.accelerationIncludingGravity.x;
            y = event.accelerationIncludingGravity.y;
          } else if (event.acceleration) {
            x = event.acceleration.x;
            y = event.acceleration.y;
          }
          if (x == null) {
            x = 0
          };
          if (y == null) {
            y = 0
          };
          //y = y.toFixed();
          var r = event.rotationRate;
          if (O == 0) {
            pitch = x;
            //Portrait;
            $Opacity = averageIt(pitch - 2, flicker);
          } else {
            //LANDSCAPE
            if ((O == 90) || (O == -90)) {
              pitch = y - 12;
              $Opacity = averageIt(pitch + 20, flicker);
            }
          }
          tilted = averageIt(pitch, flicker);
          //varies between 0 and 1
          // total range of possible tilt = 12
          var number = 1;
          var mobileRange = 18 / number_of_slides;
          var mobileZone = (tilted / mobileRange) - number_of_slides / 4;
          $Opacity = mobileZone + number_of_slides;
          Opacity = mobileZone + number_of_slides;
          var $output = "Opacity = " + Opacity + "<br> number_of_slides= " + number_of_slides + "<br>Mouse Pos = " + Mpos;
          //document.getElementById("demo").innerHTML = $output;
          number = 1;
          RowNum = 1;
          while (number <= number_of_slides) {
            if (number % 4 == 0) {
              RowNum = 1
            };
            mixOpacity('div.container' + number, $Opacity - RowNum * 3)
            number++;
            RowNum += 1;
          }
        });

        function Round(num) {
          x = num.toFixed(smoothness);
          x = Number(x);
          return x;
        }
        //further smoothing
        function averageIt(tilt, flicker) {
          averageOf.pop();
          averageOf.unshift(tilt);
          for (i = 0; i < flicker; i++) {
            totalx += averageOf[i];
          }
          avex = totalx / flicker;
          avex = Round(avex);
          tilt = avex;
          i = 0;
          totalx = 0;
          flicker = 0;
          return avex;
        }
      }
      //END tilt action specific code

      $('.box').mousemove(function(e) {
        var boxLeft = $('.box').offset().left;
        var winWidth = $('.box').width() + boxLeft + 9;
        var boxWidth = (winWidth);
        var range = (boxWidth / (number_of_slides - 1)) / 2;
        var Mpos = boxWidth - (e.pageX - boxLeft) / 2;

        autoPosFn(Mpos);

      });



      function autoPosFn(Mpos) {
        var zone = Mpos / 200; // width of travel for one slide transition
        $Opacity = zone;
        number = 1;
        RowNum = 1;
        while (number <= number_of_slides) {
          if (RowNum % 7 == 0) {
            RowNum = 1
          };
          mixOpacity('div.container' + number, $Opacity - RowNum + 1)
          number++;
          RowNum += 1;
          //console.log("div.container" + number +" Opacity = "+($Opacity+RowNum-5 ));
        }
        //allways displayed slides for row of five
        /*      mixOpacity('div.container1', 1);
                  mixOpacity('div.container4', 1);
                  mixOpacity('div.container8', 1);
                  mixOpacity('div.container12', 1);*/
      };

      function mixOpacity(div, Opacity) { // sets css opacity of DIV
        console.log(div + " Opacity = " + Opacity);
        $(div).attr("style", "opacity:" + Opacity);
        //console.log("mixOpacity Called");
      }

    </script>
