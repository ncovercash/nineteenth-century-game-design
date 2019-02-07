<!DOCTYPE html>
<html>
	<head>
		<title>
			Nineteenth Century Game Design
		</title>
		
		<script src="jquery.min.js"></script>
		
		<link href="materialize.min.css.php" rel="stylesheet"/>
		<style type="text/css">
			.no-margin {
				margin: 0 !important;
			}

			.no-bottom-margin {
				margin-bottom: 0 !important;
			}

			.no-top-margin {
				margin-top: 0 !important;
			}

			a {
				font-weight: bolder;
				color: #303f9f;
			}

			a:hover {
				text-decoration: underline;
			}

			.align-right {
				text-align: right;
			}

			.bold {
				font-weight: bold;
			}


			input[type=range] + .thumb {
				background-color: #303f9f;
			}

			input[type=range]::-webkit-slider-thumb {
				background-color: #303f9f;
			}

			input[type=range]::-moz-range-thumb {
				background: #303f9f;
			}

			input[type=range]::-ms-thumb {
				background: #303f9f;
			}

			.code-block {
				font-family: monospace;
				display: block;
				padding: 10px;
				margin: 10px;
				background-color: #f9f9f9;
			}

			.code-block * {
				font-family: monospace;
			}

			.code-block p {
				padding: 0;
				margin: 0;
			}

			.code-block p:empty {
				height: 1.5em;
			}

			.switch label input[type=checkbox]+.lever:after {
				background-color: #303f9f !important;
			}

			.switch label input[type=checkbox]+.lever {
				background-color: #9e9e9e !important;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="section">
				<h2 class="header center no-margin">19<sup>th</sup> Century Game Design</h2>
				<h5 class="header center small-margin">Noah Overcash and Harry Charles</h5>
				<h5 class="header center no-top-margin">Mr. Wallace's AP European History,Period 4</h5>

				<p>Instructions go here, try to get the most money by the year 1850</p>
			</div>
			<div class="divider"></div>
			<div class="section">
				<div class="row">
					<div class="col s12 m7 l8">
						<canvas id="canvas" style="border: 1px solid black; border-radius: 0.4em;"></canvas>
					</div>
					<div class="col s12 m5 l4">
						<h4 class="no-bottom-margin"><span id="year"></span></h4>
						<p class="no-top-margin" id="speed">12 seconds/year</p>

						<label for="speedSlider">Speed</label>
						<p class="range-field">
							<input type="range" class="col s12" id="speedSlider" min="0" max="1900" step="100" value="1000" />
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	(function($){
		$(function(){
			var canvas = document.getElementById("canvas");

			const MONTHS = ["January","February","March","April","May","June","July","August","September","October","November","December"];
			var year = 1760;
			var month = 0;

			var dateElement = document.getElementById("year");

			var paused = false;
			var dateSpeed = 1000;

			var speedSliderElement = document.getElementById("speedSlider");
			var speedValueElement = document.getElementById("speed");

			var tickTimeout = undefined;

			speedSliderElement.oninput = function(e) {
				dateSpeed = this.value;

				clearInterval(tickTimeout);
				console.log("Clearing old timeout.");

				if (dateSpeed != 0) {
					console.log("Setting timeout for "+(2000-dateSpeed)+"ms");
					tickTimeout = setTimeout(tick, 2000-dateSpeed);
				} else {
					console.log("PAUSED");
				}

				if (dateSpeed == 0) {
					speedValueElement.innerHTML = "PAUSED";
					console.log("Setting speed value to \"PAUSED\"");
				} else {
					var monthMs = 2000-dateSpeed;
					var secondsPerMonth = monthMs/1000;

					var secondsPerYear = 12*secondsPerMonth;

					console.log(""+secondsPerYear+" seconds per year");

					var roundedValue = Math.round(secondsPerYear*100)/100;

					console.log("Setting speed value to "+roundedValue);

					speedValueElement.innerHTML = ""+roundedValue+" seconds/year";
				}
			}

			function tick() {
				if (!paused) {
					month++;
					if (month >= 12) {
						year++;
						month = 0;
					}
				}

				dateElement.innerHTML = year + " " + MONTHS[month];

				if (year == 1850) {
					console.log("Ending game, year 1850 reached");
					endGame();
				}

				if (dateSpeed != 0) {
					console.log("Setting timeout for "+(2000-dateSpeed)+"ms");
					tickTimeout = setTimeout(tick, 2000-dateSpeed);
				} else {
					console.log("PAUSED");
				}
			}

			tick();
		});
	})(jQuery);
</script>

