<!DOCTYPE html>
<html>
	<head>
		<title>
			Nineteenth Century Game Design
		</title>
		
		<link href="materialize.min.css.php" rel="stylesheet"/>
		<style type="text/css">
			.small-margin {
				margin-top: 0.2em !important;
				margin-bottom: 0.2em !important;
			}

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

			.row .col {
				padding: 0.75rem;
			}

			button {
				border-width: 1px;
				border-style: solid;
				border-color: #464c54;
				
				background-color: #dcdad5;

				cursor: pointer;
			}

			button:hover {
				background-color: #eeebe7;
				border-width: 1px;
			}

			button:active, button.disabled {
				color: #9c9a95;
			}

			button.disabled {
				cursor: not-allowed;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="section">
				<h2 class="header center no-margin">19<sup>th</sup> Century Game Design</h2>
				<h5 class="header center small-margin">Noah Overcash and Harry Charles</h5>
				<h5 class="header center no-top-margin">Mr. Wallace's AP European History, Period 3A</h5>

				<p>Instructions go here, try to get the most money by the year 1860</p>
			</div>
			<div class="divider"></div>
			<div class="section">
				<div class="row">
					<div class="col s12 m7 l8">
						<?= file_get_contents("map.svg") ?>
					</div>
					<div class="col s12 m5 l4">
						<div class="col s12">
							<h4 class="no-top-margin" id="cash"></h4>
							<h4 class="no-margin"><span id="year"></span></h4>
							<p class="no-top-margin" id="speed">12 seconds/year</p>

							<label for="speedSlider">Speed</label>
							<input type="range" class="col s12" id="speedSlider" min="0" max="1900" step="100" value="1000" />
						</div>

						<div class="col s12" id="city-parameters" style="border: 1px solid black;">
							<div id="city-parameters-no-selection">
								<p class="center align-center grey-text">
									<i>
										Please select a city
									</i>
								</p>
							</div>
							<div class="hide" data-city="manchester" id="city-parameters-selected">
								<h4 class="small-margin" id="city-name"></h4>
								<h5 class="small-margin">Population <span id="city-population"></span></h5>

								<p>Worker cost: <span id="worker-cost"></span></p>

								<p class="no-bottom-margin">Proximity to water: <span id="proximity-to-water"></span></p>
								<p class="no-margin">Proximity to coal: <span id="proximity-to-coal"></span></p>
								<p class="no-top-margin">Proximity to iron: <span id="proximity-to-iron"></span></p>

								<div class="col s12" id="build-factory-display" style="border: 1px solid black">
									<p class="no-top-margin"><b>New Factory</b></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	Number.prototype.formatCommas = function(c, d, t) {
		var n = this;
		var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;

		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};

	const PROXIMITY_LABELS = {
		1: "Very Far",
		2: "Far",
		3: "Nearby",
		4: "Close",
		5: "Extremely Close"
	};

	var factoryTypes = {
		textile: {
			name: "Textiles",
			shortName: "textile",
			description: "Produces linens, wool, silk, cotton, and other textile products using the water frame.",
			factoryName: "Textile Factory",
			factoryCost: function(city) {
				return city.baseFactoryCost*(city.factoryCostMultiplier**city.numberOfFactories(this.shortName))*(1.1-(0.1*city.proximity.water));
			},
			productionPerWorker: function(city) {
				return 3/(1.1-(0.1*city.proximity.water));
			},
			demand: 100
		},
		metals: {
			name: "Metals",
			shortName: "metals",
			description: "Produces iron, steel, tin, and other essential materials for construction.",
			factoryName: "Metal Refinery",
			factoryCost: function(city) {
				return city.baseFactoryCost*(city.factoryCostMultiplier**city.numberOfFactories(this.shortName))*(1.2-(0.05*city.proximity.iron)-(0.05*city.proximity.coal));
			},
			productionPerWorker: function(city) {
				return 2/(1.2-(0.05*city.proximity.iron)-(0.05*city.proximity.coal));
			},
			demand: 100
		},
		consumerGoods: {
			name: "Consumer Goods",
			shortName: "consumerGoods",
			description: "Produces consumer goods for the average person to use.",
			factoryName: "General Factory",
			factoryCost: function(city) {
				return city.baseFactoryCost*(city.factoryCostMultiplier**city.numberOfFactories(this.shortName))*(1.1-(0.03*city.proximity.water)-(0.03*city.proximity.iron)-(0.03*city.proximity.coal));
			},
			productionPerWorker: function(city) {
				return 4/(1.15-(0.05*city.proximity.water)-(0.05*city.proximity.iron)-(0.05*city.proximity.coal));
			},
			demand: 100
		}
	};

	var factories = [];

	var cityDefinitions = {
		milan: {
			shortName: "milan",
			name: "Milan, Italy",
			proximity: {
				water: 4,
				iron: 5,
				coal: 1
			},
			population: function(year) {
				var decade = Math.floor(year/10);
				var decadeYear = year%10+(month/12);

				switch (decade) {
					case 176:
						return 123618 + 485.4*decadeYear;
					case 177:
						return 128472 + 605.6*decadeYear;
					case 178:
						return 134528 + 850*decadeYear;
					case 179:
						return 143028 + 935.6*decadeYear;
					case 180:
						return 152384 + 774.5*decadeYear;
					case 181:
						return 160129 + 519.9*decadeYear;
					case 182:
						return 165328 + 671*decadeYear;
					case 183:
						return 172038 + 819.6*decadeYear;
					case 184:
						return 180234 + 1319.9*decadeYear;
					case 185:
						return 193433 + 0*decadeYear;
					default:
						throw "Year "+year+" is not known for "+this.name+".";
				}
			},
			baseFactoryCost: 50000,
			factoryCostMultiplier: 1.8,
			numberOfFactories: function(type) {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName && factories[i].type == type) {
						num++;
					}
				}
				return num;
			},
			numberOfWorkers: function() {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName) {
						num += factories[i].numberOfWorkers;
					}
				}
				return num;
			},
			workerCost: function() {
				return 2500*((1+1000*this.numberOfWorkers()/this.population(year, month))**2);
			}
		},
		essen: {
			shortName: "essen",
			name: "Essen, Prussia",
			proximity: {
				water: 5,
				iron: 4,
				coal: 5
			},
			population: function(year) {
				var decade = Math.floor(year/10);
				var decadeYear = year%10+(month/12);

				switch (decade) {
					case 176:
						return 5012843 + 47998.9*decadeYear;
					case 177:
						return 5492832 + 23566.1*decadeYear;
					case 178:
						return 5728493 + 26343.9*decadeYear;
					case 179:
						return 5991932 + 49944.3*decadeYear;
					case 180:
						return 6491375 + 47281.9*decadeYear;
					case 181:
						return 6964194 + 28439.8*decadeYear;
					case 182:
						return 7248592 + 26434.6*decadeYear;
					case 183:
						return 7512938 + 41095.5*decadeYear;
					case 184:
						return 7923893 + 42012.6*decadeYear;
					case 185:
						return 8344019 + 0*decadeYear;
					default:
						throw "Year "+year+" is not known for "+this.name+".";
				}
			},
			baseFactoryCost: 40000,
			factoryCostMultiplier: 1.8,
			numberOfFactories: function(type) {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName && factories[i].type == type) {
						num++;
					}
				}
				return num;
			},
			numberOfWorkers: function() {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName) {
						num += factories[i].numberOfWorkers;
					}
				}
				return num;
			},
			workerCost: function() {
				return 2500*((1+1000*this.numberOfWorkers()/this.population(year, month))**2);
			}
		},
		paris: {
			shortName: "paris",
			name: "Paris, France",
			proximity: {
				water: 5,
				iron: 1,
				coal: 2
			},
			population: function(year) {
				var decade = Math.floor(year/10);
				var decadeYear = year%10+(month/12);

				switch (decade) {
					case 176:
						return 566283 + 1591*decadeYear;
					case 177:
						return 582193 + 2718.8*decadeYear;
					case 178:
						return 609381 + 2145.1*decadeYear;
					case 179:
						return 630832 - 8397.6*decadeYear;
					case 180:
						return 546856 + 7578*decadeYear;
					case 181:
						return 622636 + 11133*decadeYear;
					case 182:
						return 733966 + 5189.6*decadeYear;
					case 183:
						return 785862 + 14939.9*decadeYear;
					case 184:
						return 935261 + 11800.05*decadeYear;
					case 185:
						return 1053262 + 0*decadeYear;
					default:
						throw "Year "+year+" is not known for "+this.name+".";
				}
			},
			baseFactoryCost: 35000,
			factoryCostMultiplier: 1.8,
			numberOfFactories: function(type) {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName && factories[i].type == type) {
						num++;
					}
				}
				return num;
			},
			numberOfWorkers: function() {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName) {
						num += factories[i].numberOfWorkers;
					}
				}
				return num;
			},
			workerCost: function() {
				return 2500*((1+1000*this.numberOfWorkers()/this.population(year, month))**2);
			}
		},
		london: {
			shortName: "london",
			name: "London, England",
			proximity: {
				water: 5,
				iron: 1,
				coal: 5
			},
			population: function(year) {
				var decade = Math.floor(year/10);
				var decadeYear = year%10+(month/12);

				switch (decade) {
					case 176:
						return 770367 + 53721*decadeYear;
					case 177:
						return 824088 + 41205*decadeYear;
					case 178:
						return 865293 + 53937*decadeYear;
					case 179:
						return 919230 + 91927*decadeYear;
					case 180:
						return 1011157 + 186516*decadeYear;
					case 181:
						return 1197673 + 252449*decadeYear;
					case 182:
						return 1450122 + 279827*decadeYear;
					case 183:
						return 1729949 + 187064*decadeYear;
					case 184:
						return 1917013 + 369596*decadeYear;
					case 185:
						return 2286609 + 0*decadeYear;
					default:
						throw "Year "+year+" is not known for "+this.name+".";
				}
			},
			baseFactoryCost: 17500,
			factoryCostMultiplier: 1.8,
			numberOfFactories: function(type) {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName && factories[i].type == type) {
						num++;
					}
				}
				return num;
			},
			numberOfWorkers: function() {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName) {
						num += factories[i].numberOfWorkers;
					}
				}
				return num;
			},
			workerCost: function() {
				return 2500*((1+1000*this.numberOfWorkers()/this.population(year, month))**2);
			}
		},
		manchester: {
			shortName: "manchester",
			name: "Manchester, England",
			proximity: {
				water: 5,
				iron: 1,
				coal: 5
			},
			population: function(year, month) {
				var decade = Math.floor(year/10);
				var decadeYear = year%10+(month/12);

				switch (decade) {
					case 176:
						return 100236 + 4001*decadeYear;
					case 177:
						return 140103 + 5312*decadeYear;
					case 178:
						return 193723 + 7483*decadeYear;
					case 179:
						return 267123 + 7523*decadeYear;
					case 180:
						return 328609 + 8085*decadeYear;
					case 181:
						return 409464 + 11677*decadeYear;
					case 182:
						return 526230 + 17426*decadeYear;
					case 183:
						return 700486 + 15993*decadeYear;
					case 184:
						return 860413 + 17659*decadeYear;
					case 185:
						return 1037001 + 0*decadeYear;
					default:
						throw "Year "+year+" is not known for "+this.name+".";
				}
			},
			baseFactoryCost: 10000,
			factoryCostMultiplier: 1.8,
			numberOfFactories: function(type) {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName && factories[i].type == type) {
						num++;
					}
				}
				return num;
			},
			numberOfWorkers: function() {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName) {
						num += factories[i].numberOfWorkers;
					}
				}
				return num;
			},
			workerCost: function() {
				return 2500*((1+1000*this.numberOfWorkers()/this.population(year, month))**2);
			}
		},
		birmingham: {
			shortName: "birmingham",
			name: "Birmingham, England",
			proximity: {
				water: 3,
				iron: 1,
				coal: 4
			},
			population: function(year) {
				var decade = Math.floor(year/10);
				var decadeYear = year%10+(month/12);

				switch (decade) {
					case 176:
						return 34886 + 403*decadeYear;
					case 177:
						return 38204 + 501*decadeYear;
					case 178:
						return 43232 + 1423*decadeYear;
					case 179:
						return 57462 + 1602*decadeYear;
					case 180:
						return 73760 + 1199.3*decadeYear;
					case 181:
						return 85753 + 2097*decadeYear;
					case 182:
						return 106722 + 4026*decadeYear;
					case 183:
						return 146986 + 3594*decadeYear;
					case 184:
						return 182922 + 4972*decadeYear;
					case 185:
						return 232638 + 0*decadeYear;
					default:
						throw "Year "+year+" is not known for "+this.name+".";
				}
			},
			baseFactoryCost: 15000,
			factoryCostMultiplier: 1.8,
			numberOfFactories: function(type) {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName && factories[i].type == type) {
						num++;
					}
				}
				return num;
			},
			numberOfWorkers: function() {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName) {
						num += factories[i].numberOfWorkers;
					}
				}
				return num;
			},
			workerCost: function() {
				return 2500*((1+1000*this.numberOfWorkers()/this.population(year, month))**2);
			}
		},
		bristol: {
			shortName: "bristol",
			name: "Bristol, England",
			proximity: {
				water: 5,
				iron: 1,
				coal: 4
			},
			population: function(year) {
				var decade = Math.floor(year/10);
				var decadeYear = year%10+(month/12);

				switch (decade) {
					case 176:
						return 40124 + 569.9*decadeYear;
					case 177:
						return 45823 + 648.1*decadeYear;
					case 178:
						return 52304 + 704.8*decadeYear;
					case 179:
						return 59352 + 959.2*decadeYear;
					case 180:
						return 68944 + 1497.8*decadeYear;
					case 181:
						return 83922 + 1522.9*decadeYear;
					case 182:
						return 99151 + 2163.8*decadeYear;
					case 183:
						return 120789 + 2401.4*decadeYear;
					case 184:
						return 144803 + 1514.2*decadeYear;
					case 185:
						return 159945 + 0*decadeYear;
					default:
						throw "Year "+year+" is not known for "+this.name+".";
				}
			},
			baseFactoryCost: 15000,
			factoryCostMultiplier: 1.8,
			numberOfFactories: function(type) {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName && factories[i].type == type) {
						num++;
					}
				}
				return num;
			},
			numberOfWorkers: function() {
				var num = 0;
				for (var i=0; i<factories.length; i++) {
					if (factories[i].city == this.shortName) {
						num += factories[i].numberOfWorkers;
					}
				}
				return num;
			},
			workerCost: function() {
				return 2500*((1+1000*this.numberOfWorkers()/this.population(year, month))**2);
			}
		},
	};

	const MONTHS = ["January","February","March","April","May","June","July","August","September","October","November","December"];
	var year = 1760;
	var month = 0;

	var cash = 10000;
	var cashElement = document.getElementById("cash");

	var dateElement = document.getElementById("year");

	var paused = false;
	var dateSpeed = 1000;
	var lastTick = Date.now();

	var speedSliderElement = document.getElementById("speedSlider");
	var speedValueElement = document.getElementById("speed");

	var cityParametersNotSelectedElement = document.getElementById("city-parameters-no-selection");
	var cityParametersElement = document.getElementById("city-parameters-selected");

	var cityName = document.getElementById("city-name");
	var cityPopulationElement = document.getElementById("city-population");

	var cityWorkerCostElement = document.getElementById("worker-cost");

	var cityProximityToWaterElement = document.getElementById("proximity-to-water");
	var cityProximityToCoalElement = document.getElementById("proximity-to-coal");
	var cityProximityToIronElement = document.getElementById("proximity-to-iron");

	var tickTimeout = undefined;

	function tick() {
		lastTick = Date.now();

		if (!paused) {
			month++;
			if (month >= 12) {
				year++;
				month = 0;
			}
		}

		dateElement.innerHTML = year + " " + MONTHS[month];

		if (year == 1860) {
			console.log("Ending game, year 1860 reached");
			endGame();
			return;
		}

		var selectedCity = cityDefinitions[cityParametersElement.getAttribute("data-city")];
		cityPopulationElement.innerHTML = selectedCity.population(year, month).formatCommas(0);

		cashElement.innerHTML = "$"+cash.formatCommas();

		if (dateSpeed != 0) {
			console.log("Setting timeout for "+(2000-dateSpeed)+"ms");
			tickTimeout = setTimeout(tick, 2000-dateSpeed);
		} else {
			console.log("PAUSED");
		}
	}

	speedSliderElement.oninput = function(e) {
		dateSpeed = this.value;

		clearInterval(tickTimeout);
		console.log("Clearing old timeout.");

		if (dateSpeed != 0) {
			var timeoutLength = 2000-dateSpeed;

			console.log("Timeout is "+timeoutLength+"ms");
			
			var sinceLastTick = Date.now()-lastTick;

			console.log(""+sinceLastTick+"ms since last tick; effective timeout for this iteration is "+(timeoutLength-sinceLastTick));

			if (timeoutLength-sinceLastTick <= 0) {
				console.log("Timeout is <=0, ticking NOW");
				tick();
			} else {
				tickTimeout = setTimeout(tick, timeoutLength-sinceLastTick);
			}
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

	function initClickableMapItems() {
		var clickableMapItems = document.getElementsByClassName("map-clickable");

		for (var i=0; i<clickableMapItems.length; i++) {
			clickableMapItems[i].onclick = function() {
				var transientItems = document.querySelectorAll(".transient-city");

				for (var i=0; i<transientItems.length; i++) {
					transientItems[i].outerHTML = "";
				}

				var city = cityDefinitions[this.getAttribute("data-city")];

				cityParametersNotSelectedElement.classList.add("hide");
				cityParametersElement.classList.remove("hide");

				cityName.innerHTML = city.name;
				cityParametersElement.setAttribute("data-city", city.shortName);
				cityPopulationElement.innerHTML = city.population(year, month).formatCommas(0);

				cityWorkerCostElement.innerHTML = "$"+city.workerCost().formatCommas(2);

				cityProximityToWaterElement.innerHTML = PROXIMITY_LABELS[city.proximity.water];
				cityProximityToCoalElement.innerHTML = PROXIMITY_LABELS[city.proximity.coal];
				cityProximityToIronElement.innerHTML = PROXIMITY_LABELS[city.proximity.iron];

				for (i=0; i<clickableMapItems.length; i++) {
					clickableMapItems[i].style.stroke = "#ffffff";
				}
		
				var cityItems = document.querySelectorAll(".map-clickable[data-city="+this.getAttribute("data-city")+"]");
		
				for (i=0; i<cityItems.length; i++) {
					cityItems[i].style.stroke = "#f44336";
				}

				for (factory in factoryTypes) {
					var factoryType = factoryTypes[factory];

					var factoryWrapper = document.createElement("div");
					factoryWrapper.classList.add("transient-city");
					factoryWrapper.style.border = "1px solid black";
					factoryWrapper.style.padding = "0.4em"

					var factoryName = document.createElement("p");
					factoryName.classList.add("no-margin");
					factoryName.style.fontWeight = "bold";
					factoryName.appendChild(document.createTextNode(factoryType.factoryName));
					factoryWrapper.appendChild(factoryName);

					var factoryDescription = document.createElement("p");
					factoryDescription.classList.add("no-margin");
					factoryDescription.appendChild(document.createTextNode(factoryType.description));
					factoryWrapper.appendChild(factoryDescription);

					var factoryProfit = document.createElement("p");
					factoryProfit.classList.add("no-margin");
					factoryProfit.appendChild(document.createTextNode("Profit: $"+(factoryType.productionPerWorker(city)*factoryType.demand).formatCommas(2)+"/worker/month"));
					factoryWrapper.appendChild(factoryProfit);

					var factoryBuyButton = document.createElement("button");
					factoryBuyButton.classList.add("factory-buy-button");
					factoryBuyButton.appendChild(document.createTextNode("$"+(factoryType.factoryCost(city)).formatCommas(2)));
					factoryWrapper.appendChild(factoryBuyButton);

					cityParametersElement.appendChild(factoryWrapper);
				}
			};
		}
	};
	initClickableMapItems();

	tick();
</script>
