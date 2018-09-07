//MAIN DASHBOARD PHOTO SLIDER SCRIPT

    // TILT action code
    var gama = null;
    var thumbZone = null;
    var ipad = "false";
var numberOfThumbSlides = "<?php echo $count ?>";
//var numberOfThumbSlides = 10;
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
    var thumbRange = null;
    var mobileRange = null;
    var thumbOpTemp = null;
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

          thumbOpTemp = averageIt(pitch - 2, flicker);
        } else {

          //LANDSCAPE
          if ((O == 90) || (O == -90)) {
            pitch = y - 12;
            thumbOpTemp = averageIt(pitch + 20, flicker);
          }
        }

        tilted = averageIt(pitch, flicker);

        var number = 0;
        var mobileRange = 12 / numberOfThumbSlides;
        var mobileZone = (tilted / mobileRange)-numberOfThumbSlides/4;
        thumbOpTemp = mobileZone + numberOfThumbSlides;
        //Opacity = mobileZone + numberOfThumbSlides;


        while (number <= numberOfThumbSlides) { // MOBILE image holder generation
          mixThumbOpacity('div.container' + number, thumbOpTemp - number+1);
          mixThumbOpacity('div.container1', 1);
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



    $('#thumbPhotos').mousemove(function(thumbE) { //width/speed/left offset
      var thumbBoxLeft = $('#thumbPhotos').offset().left;
      var thumbWinWidth = $('#thumbPhotos').width() + thumbBoxLeft;
      var thumbBoxWidth = thumbWinWidth - thumbBoxLeft * 2;
      var thumbRange = (thumbBoxWidth) / (numberOfThumbSlides /5);

      var thumbRelX = thumbE.pageX + thumbRange;
      var thumbMpos = thumbE.pageX - thumbBoxLeft;
      var thumbZone = thumbMpos / thumbRange;
      thumbOpTemp = thumbZone + numberOfThumbSlides/2;
      number = 1;
      
      while (number <= numberOfThumbSlides) {
        mixThumbOpacity('div.container' + number, thumbOpTemp - number)
        number++;
        console.log(thumbOpTemp);
      }
    });



    function mixThumbOpacity(div, Opacity) { // sets css opacity of DIV
      $(#thumbnails div).attr("style", "opacity:" + Opacity);
    }