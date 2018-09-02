

    // TILT action code
    var gama = null;
    var zone = null;
    var ipad = "false";
//var number_of_slides = "<?php echo $count ?>";
var number_of_slides = 10;
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
    var OpTemp = null;
    var smoothness = 4;
    var averageOf = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
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

          OpTemp = averageIt(pitch - 2, flicker);
        } else {

          //LANDSCAPE
          if ((O == 90) || (O == -90)) {
            pitch = y - 12;
            OpTemp = averageIt(pitch + 20, flicker);
          }
        }

        tilted = averageIt(pitch, flicker);

        var number = 0;
        var mobileRange = 12 / number_of_slides;
        var mobileZone = (tilted / mobileRange)-number_of_slides/4;
        OpTemp = mobileZone + number_of_slides;
        //Opacity = mobileZone + number_of_slides;


        while (number <= number_of_slides) { // MOBILE image holder generation
          mixOpacity('div.container' + number, OpTemp - number+1);
          mixOpacity('div.container1', 1);
          number++;
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



    $('#photos').mousemove(function(e) { //width/speed/left offset
      var boxLeft = $('#photos').offset().left;
      var winWidth = $('#photos').width() + boxLeft;
      var boxWidth = winWidth - boxLeft * 2;
      var range = (boxWidth) / (number_of_slides /5);

      var relX = e.pageX + range;
      var Mpos = e.pageX - boxLeft;
      var zone = Mpos / range;
      OpTemp = zone + number_of_slides/2;
      number = 1;
      
      while (number <= number_of_slides) {
        mixOpacity('div.container' + number, OpTemp - number)
        number++;
        console.log(OpTemp);
      }
    });



    function mixOpacity(div, Opacity) { // sets css opacity of DIV
      $(div).attr("style", "opacity:" + Opacity);
    }