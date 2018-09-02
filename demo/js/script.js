var fileobj;
	function upload_file(e) {
		e.preventDefault();
		fileobj = e.dataTransfer.files[0];
		ajax_file_upload(fileobj);
	}

	function file_explorer() {
		document.getElementById('selectfile').click();
		document.getElementById('selectfile').onchange = function() {
		    fileobj = document.getElementById('selectfile').files[0];
			ajax_file_upload(fileobj);
		};
	}

	function ajax_file_upload(file_obj) {
		if(file_obj != undefined) {
		    var form_data = new FormData();                  
		    form_data.append('file', file_obj);
			$.ajax({
				type: 'POST',
				url: 'ajax.php',
				contentType: false,
				processData: false,
				data: form_data,
				success:function(response) {
					alert(response);
					$('#selectfile').val('');
				}
			});
		}
	}
 
 function _isMobile() {
      var isMobile = (/iphone|ipod|android|ie|blackberry|fennec/).test(navigator.userAgent.toLowerCase());
      return isMobile;
    }
    mobile = _isMobile();


    // TILT action code
    var gama = null;
    var zone = null;
    var ipad = "false";
    //var number_of_slides = <?php echo $count ?>;
var number_of_slides = 8;
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
        //$Opacity = tilted + 1/number_of_slides;
        //Opacity = tilted + 1/number_of_slides;
        //var opacity_number = Opacity;

        var number = 0;
        var mobileRange = 12 / number_of_slides;
        var mobileZone = (tilted / mobileRange)-number_of_slides/4;
        $Opacity = mobileZone + number_of_slides;
        Opacity = mobileZone + number_of_slides;


        while (number <= number_of_slides) { // MOBILE image holder generation
          mixOpacity('div.container' + number, $Opacity - number+1);
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


    //END tilt action specific code
    //END tilt action specific code
    //END tilt action specific code
    //END tilt action specific code





    $('#box').mousemove(function(e) { //width/speed/left offset
      var boxLeft = $('#box').offset().left;
      var winWidth = $('#box').width() + boxLeft + 9;
      var boxWidth = winWidth - boxLeft * 2;
      var range = (boxWidth) / (number_of_slides - 1);

      var relX = e.pageX + range;
      var Mpos = e.pageX - boxLeft;
      var zone = Mpos / range;
      $Opacity = number_of_slides - zone;
      number = 1;
      while (number <= number_of_slides) {
        mixOpacity('div.container' + number, $Opacity - number + 1)
        number++;
      }
    });



    function mixOpacity(div, Opacity) { // sets css opacity of DIV
      $(div).attr("style", "opacity:" + Opacity);
    }

    if (typeof console != "undefined")
      if (typeof console.log != 'undefined')
        console.olog = console.log;
      else
        console.olog = function() {};

    console.log = function(message) {
      console.olog(message);
      $('#debug').append('<p>' + message + '</p>');
    };
    console.error = console.debug = console.info = console.log



document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')