<?php

/*
if(!isset($_GET["b"])){
echo "<script>
alert('Mohon klik tombol monitoring yang terdapat di list pasien , terima kasih'); window.location = './indexdokter.php';</script>";}
*/
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");
if(empty($_SESSION['level'])) {
		echo '<script type="text/javascript">window.location.href="index.php";</script>';
}else{
	if(!isset($_GET['deviceid']) ){
		if($_SESSION['level']=="dokter"){
			echo '<script type="text/javascript">alert(\'Mohon klik tombol monitoring yang terdapat di list pasien , terima kasih\'); window.location.href="datapasien.php";</script>';
		}else if($_SESSION['level']=="pasien"){
			echo "<script type=\"text/javascript\">window.location.href=\"monitoring.php?deviceid=\"'".$_SESSION['deviceid']."';</script>";
		}
		}
}

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Monitoring";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["dashboard"]["sub"]["monitoring"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->

			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-sortable="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<?php
						$result = mysqli_query($mysqli, "SELECT * FROM data_pasien WHERE device_id='".$_GET['deviceid']."'");
						$res = mysqli_fetch_array($result)
						 ?>
						<header>
							<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
							<h2>Live Monitoring <?php echo $res['nama_pasien']; ?></h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<canvas id="ecg">
				</canvas>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-3" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-sortable="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
							<h2>Monitoring Report </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

								<div class="well well-sm">
					<!-- Timeline Content -->
					<div class="smart-timeline">
						<ul class="smart-timeline-list">
							<li>
								<div class="smart-timeline-icon bg-color-greenDark">
									<i class="fa fa-bar-chart-o"></i>
								</div>
								<div class="smart-timeline-time">
									<small>5 hrs ago</small>
								</div>
								<div class="smart-timeline-content">
									<p>
										<strong class="txt-color-greenDark">Normal Heartbeat</strong>
									</p>

									<br>
								</div>
							</li>
							<li>
								<div class="smart-timeline-icon bg-color-greenDark">
									<i class="fa fa-bar-chart-o"></i>
								</div>
								<div class="smart-timeline-time">
									<small>4 hrs ago</small>
								</div>
								<div class="smart-timeline-content">
									<p>
										<strong class="txt-color-greenDark">Normal Heartbeat</strong>
									</p>

									<br>
								</div>
							</li>
							<li>
								<div class="smart-timeline-icon bg-color-greenDark">
									<i class="fa fa-bar-chart-o"></i>
								</div>
								<div class="smart-timeline-time">
									<small>3 hrs ago</small>
								</div>
								<div class="smart-timeline-content">
									<p>
										<strong class="txt-color-greenDark">Normal Heartbeat</strong>
									</p>

									<br>
								</div>
							</li>
							<li>
								<div class="smart-timeline-icon bg-color-greenDark">
									<i class="fa fa-bar-chart-o"></i>
								</div>
								<div class="smart-timeline-time">
									<small>2 hrs ago</small>
								</div>
								<div class="smart-timeline-content">
									<p>
										<strong class="txt-color-greenDark">Normal Heartbeat</strong>
									</p>

									<br>
								</div>
							</li>
						</ul>
					</div>
					<!-- END Timeline Content -->

				</div>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

			</div>

			<!-- end row -->

			<!-- row -->



			<!-- end row -->

		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
	//include required scripts
	include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S)
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/pahomqtt.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/mqtt.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>
<script>
	$(document).ready(function() {
		/*
		 *
		 * Photoplethysmograph (Real Time PPG Grapher)
		 *
		 *    by: Tso (Peter) Chen
		 *
		 *
		 *
		 * 0.1 - first version
		 *
		 *
		 * Absolutely free to use, copy, edit, share, etc.
		 *--------------------------------------------------*/

		  /*
		   * Helper function to convert a number to the graph coordinate
		   * ----------------------------------------------------------- */
		  function convertToGraphCoord(g, num){
		    return Math.floor((g.height / 2) * -(num * g.scaleFactor) + g.height / 2);
		  }

		  /*
		   * Constructor for the PlethGraph object
		   * ----------------------------------------------------------- */
		  function PlethGraph(cid, datacb){

		    var g             =   this;
		    g.canvas_id       =   cid;
		    g.canvas          =   $("#" + cid);
		    g.context         =   g.canvas[0].getContext("2d");
		    g.width           =   $("#" + cid).width();
		    g.height          =   $("#" + cid).height();
		    g.white_out       =   g.width * 0.01;
		    g.fade_out        =   g.width * 0.10;
		    g.fade_opacity    =   0.2;
		    g.current_x       =   0;
		    g.current_y       =   0;
		    g.erase_x         =   null;
		    g.speed           =   2;
		    g.linewidth       =   1;
		    g.scaleFactor     =   1;
		    g.stop_graph      =   true;

		    g.plethStarted    =   false;
		    g.plethBuffer     =   new Array();


		    devicePixelRatio = window.devicePixelRatio || 1,
		    backingStoreRatio = g.context.webkitBackingStorePixelRatio ||
		                        g.context.mozBackingStorePixelRatio ||
		                        g.context.msBackingStorePixelRatio ||
		                        g.context.oBackingStorePixelRatio ||
		                        g.context.backingStorePixelRatio || 1,

		    ratio = devicePixelRatio / backingStoreRatio;


		    var oldWidth = g.width;
		    var oldHeight = g.canvas[0].height;

		    g.canvas[0].width = oldWidth * ratio;
		    g.canvas[0].height = oldHeight * ratio;

		    g.canvas[0].style.width = '100%';
		    g.canvas[0].style.height = oldHeight + 'px';

		    // now scale the context to counter
		    // the fact that we've manually scaled
		    // our canvas element
		    g.context.scale(ratio, ratio);


		    /*
		     * The call to fill the data buffer using
		     * the data callback
		     * ---------------------------------------- */
		    g.fillData = function() {
		      g.plethBuffer = datacb();
		      };

		    /*
		     * The call to check whether graphing is on
		     * ---------------------------------------- */
		    g.isActive = function() {
		      return !g.stop_graph;
		    };

		    /*
		     * The call to stop the graphing
		     * ---------------------------------------- */
		    g.stop = function() {
		      g.stop_graph = true;
		    };


		    /*
		     * The call to wrap start the graphing
		     * ---------------------------------------- */
		    g.start = function() {
		      g.stop_graph = false;
		      g.animate();
		    };


		    /*
		     * The call to start the graphing
		     * ---------------------------------------- */
		    g.animate = function() {
		      reqAnimFrame =   window.requestAnimationFrame       ||
		                       window.mozRequestAnimationFrame    ||
		                       window.webkitRequestAnimationFrame ||
		                       window.msRequestAnimationFrame     ||
		                       window.oRequestAnimationFrame;

		      // Recursive call to do animation frames
		      if (!g.stop_graph) reqAnimFrame(g.animate);

		      // We need to fill in data into the buffer so we know what to draw
		      g.fillData();

		      // Draw the frame (with the supplied data buffer)
		      g.draw();
		    };


		    g.draw = function() {
		      // Circle back the draw point back to zero when needed (ring drawing)
		      g.current_x = (g.current_x > g.width) ? 0 : g.current_x;

		      // "White out" a region before the draw point
		      for( i = 0; i < g.white_out ; i++){
		        g.erase_x = (g.current_x + i) % g.width;
		        g.context.clearRect(g.erase_x, 0, 1, g.height);
		      }

		      // "Fade out" a region before the white out region
		      for( i = g.white_out ; i < g.fade_out ; i++ ){
		        g.erase_x = (g.current_x + i) % g.width;
		        g.context.fillStyle="rgba(255, 255, 255, " + g.fade_opacity.toString() + ")";
		        g.context.fillRect(g.erase_x, 0, 1, g.height);
		      }

		      // If this is first time, draw the first y point depending on the buffer
		      if (!g.started) {
		        g.current_y = convertToGraphCoord(g, g.plethBuffer[0]);
		        g.started = true;
		      }

		      // Start the drawing
		      g.context.beginPath();

		      // We first move to the current x and y position (last point)
		      g.context.moveTo(g.current_x, g.current_y);

		      for (i = 0; i < g.plethBuffer.length; i++) {
		        // Put the new y point in from the buffer
		        g.current_y = convertToGraphCoord(g, g.plethBuffer[i]);

		        // Draw the line to the new x and y point
		        g.context.lineTo(g.current_x += g.speed, g.current_y);

		        // Set the
		        g.context.lineWidth   = g.linewidth;
		        g.context.lineJoin    = "round";

		        // Create stroke
		        g.context.stroke();
		      }

		      // Stop the drawing
		      g.context.closePath();
		    };
		  }



		 // --------------------------- Noise Demo

		 var lastData = 0;

		  // Create a random function that is dependent on the last value
		  function hysteresisRandom(){
		    lastData += (Math.floor((Math.random() * 5) + 1)-3)/50;
		    if (Math.abs(lastData) >= 1) lastData = (lastData > 0) ? 1 : -1;
		    return lastData;
		  }


		    var ECG_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
		                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
		                    0.08, 0.18, 0.08, 0, 0, 0, 0, 0, 0, -0.04,
		                    -0.08, 0.3, 0.7, 0.3, -0.17, 0.00, 0.04, 0.04,
		                    0.05, 0.05, 0.06, 0.07, 0.08, 0.10, 0.11, 0.11,
		                    0.10, 0.085, 0.06, 0.04, 0.03, 0.01, 0.01, 0.01,
		                    0.01, 0.02, 0.03, 0.05, 0.05, 0.05, 0.03, 0.02, 0, 0, 0,
		  				  ];

		    var ECG_idx = 0;

		    function getECG(){
		      if (ECG_idx++ >= ECG_data.length - 1) ECG_idx=0;
		      var output = new Array();
		      output[0] = ECG_data[ECG_idx] + hysteresisRandom()/10;
		      return output;
		    }
		    var ecg;
		    ecg = new PlethGraph("ecg", getECG);
		    ecg.speed = 1.5;
		    ecg.scaleFactor = 0.8;

		      ecg.start();



	});

</script>
<script src="https://unpkg.com/mqtt@2.10.0/dist/mqtt.min.js"></script>
<script>
console.log("MQTT Test");
  var client = mqtt.connect({hostname:"nyamuk.scrapforparts.com",username:"R", password:"RhythmD3Vel",port:8083,protocol:'wss',clientId:"MQTT"})
	var message = "[test,tast,tost]";
  client.on('connect', function () {
    console.log("Connected");
    client.subscribe('Rhythym-N')
    client.publish('Rhythym-N', message)
  })

  client.on('message', function (topic, message) {
    // message is Buffer
    console.log(message.toString())
    client.end()
  })
</script>

<?php
	//include footer
	include("inc/google-analytics.php");
?>
