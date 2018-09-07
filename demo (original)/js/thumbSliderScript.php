<?php
  echo'<script>
alert("start script");

function _isMobile() {
      var isMobile = (/iphone|ipod|android|ie|blackberry|fennec/).test(navigator.userAgent.toLowerCase());
      return isMobile;
    }
    mobile = _isMobile();


    // TILT action code
    var gama = null;
    var zone = null;
    var ipad = "false";
    var number_of_slides = <?php echo $count ;$_SESSION["target"] = $count;?>;
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


        if (mobile = "false") {
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
        }
      });
    }

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

    //END tilt action specific code
$('.thumbBox').mousemove(function(e) {
     var thumbBoxLeft = $('#thumbnails').offset().left;
      var thumbBoxWidth = $('#thumbnails').width();
      var thumbMpos = thumbBoxWidth - (e.pageX - thumbBoxLeft);
      console.log("thumbMpos = " + thumbMpos);
      var thumbZone = (thumbMpos / number_of_slides*0.6) ; 
        console.log("thumbMpos = " + thumbMpos);
      $thumbOpacity = thumbZone+3;
      console.log("$thumbOpacity= " + $thumbOpacity);
    while (number <= number_of_slides) {
        mixOpacity('div.thumbContainer' + number, $thumbOpacity);
        number++;
      }
      //allways displayed slides
});




    $('.box').mousemove(function(e) {
     var boxLeft = $('.box').offset().left;

      //console.log("boxLeft = " + boxLeft);
/*      var winWidth = $('.box').width() + boxLeft + 9;
      console.log("winWidth = " + winWidth);
      var bodyWidth = $('body').width();
      console.log("bodyWidth = " + bodyWidth);*/
      
      var boxWidth = $('.box').width();
      //console.log("boxWidth = " + boxWidth);
      var Mpos = boxWidth - (e.pageX - boxLeft);
      console.log("Mpos = " + Mpos);
      //var scale = (boxWidth / 500); 
      //console.log("scale = " + scale);
      var zone = (Mpos / number_of_slides*0.6) ; // width of travel for one slide transition
      console.log("zone = " + zone);
      $Opacity = zone; // width of travel for one slide transition
      console.log("$Opacity= " + $Opacity);

      number = 1; 
      RowNum = 1;
      
      
      while (number <= number_of_slides) {
        if (RowNum % 7 == 0) {
          RowNum = 1
        };
        mixOpacity('div.container' + number, $Opacity - RowNum + 1);
        number++;
        RowNum += 1;
        //console.log("div.container" + number +" Opacity = "+($Opacity+RowNum-5 ));
      }
      //allways displayed slides for row of five
      mixOpacity('#thumbnails div:first-child', 1); mixOpacity('#table_container .col_0 div:first-child', 1); mixOpacity('#table_container .col_1 div:first-child', 1); mixOpacity('#table_container .col_2 div:first-child', 1); mixOpacity('#table_container .col_3 div:first-child', 1);

    });

    function mixOpacity(div, Opacity) { // sets css opacity of DIV
      //console.log(div + " Opacity = " + Opacity);
      $(div).attr("style", "opacity:" + Opacity);
      
      //console.log("mixOpacity Called");
    };
    alert();
</script>';
?>