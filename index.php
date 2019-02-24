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

			svg {
				touch-action: manipulation;
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

				touch-action: manipulation;
			}

			button.red-button {
				background-color: #e57373;
				border-color: #b71c1c;
			}

			button:hover {
				background-color: #eeebe7;
				border-width: 1px;
			}

			button.red-button:hover {
				background-color: #ef9a9a;
			}

			button:active, button.disabled {
				color: #9c9a95;
			}

			button.disabled {
				cursor: not-allowed;
			}

			button.disabled.red-button {
				color: #b71c1c;
			}

			blockquote {
			  margin: 20px 0;
			  padding-left: 1.5rem;
			  padding-top: 8px;
			  padding-bottom: 8px;
			  border-left: 5px solid #444;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="section">
				<h2 class="header center no-margin">Market Master</h2>
				<h5 class="header center small-margin">Noah Overcash and Harry Charles</h5>
				<h5 class="header center no-top-margin">Mr. Wallace's AP European History, Period 3A</h5>

				<blockquote>
					<p class="no-margin" style="font-size: 120%;"><strong>Instructions:</strong></p>

					<p class="no-margin">You are a British entrepreneur in the eighteenth and nineteenth centuries looking to make as much money as you can from industrialization.</p>
					<p class="no-margin">You have until 1860 to rack up as much profit as you can – at that point, the game is over.</p>
					<p class="no-margin">Using the slider at the right, you have the power to control time – use this to your benefit; slow time down to build factories and speed time up to amass your fortune!</p>
					<p class="no-margin">As an investor, there are many cities across Europe you can invest in.  Click on the map in order to select a city and perform actions on it.</p>
					<p class="no-margin">Once a city is selected, you can build any of the three types of factories.  However, look out for the revenue each factory produces – some are more profitable than others!</p>
					<p class="no-margin">Cities have different resources and wages – these will affect the cost of workers and the profit from each factory.</p>
					<p class="no-margin">Each factory come with one worker – up to five can be purchased per factory built.  Factories are automatically clustered based on type for easy management.</p>
					<p class="no-margin">Over time, certain inventions/social movements may occur, changing resources, wages, and factory prices at any time.</p>
				</blockquote>
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
							<p class="no-top-margin" id="speed">PAUSED</p>

							<label for="speedSlider">Speed</label>
							<input type="range" class="col s12" id="speedSlider" min="0" max="1900" step="100" value="0" />
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

								<p class="no-top-margin">Wages: <span id="worker-wages"></span>/month</p>

								<p class="no-bottom-margin">Proximity to water: <span id="proximity-to-water"></span></p>
								<p class="no-margin">Proximity to coal: <span id="proximity-to-coal"></span></p>
								<p class="no-top-margin">Proximity to iron: <span id="proximity-to-iron"></span></p>

								<div class="col s12" id="existing-factory-display" style="border: 1px solid black">
									<p class="no-top-margin"><b>Factories</b></p>

									<p id="no-existing-factories" class="center align-center grey-text">
										<i>
											There are no factories here, build some first!
										</i>
									</p>
								</div>

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

	var maxFactoryWorkers = 5;

	var transactions = [
		{
			amount: 10000,
			year: 1760,
			month: 0,
			reason: "Initial loan"
		}
	];

	var factoryTypes = <?= file_get_contents("factoryTypes.js") ?>;

	var cityDefinitions = <?= file_get_contents("cityDefinitions.js") ?>;

	const MONTHS = ["January","February","March","April","May","June","July","August","September","October","November","December"];
	var year = 1760;
	var month = 0;

	var cash = 10000;
	var cashElement = document.getElementById("cash");

	var dateElement = document.getElementById("year");

	var paused = false;
	var dateSpeed = 0;
	var lastTick = Date.now();

	var speedSliderElement = document.getElementById("speedSlider");
	var speedValueElement = document.getElementById("speed");

	var cityParametersNotSelectedElement = document.getElementById("city-parameters-no-selection");
	var cityParametersElement = document.getElementById("city-parameters-selected");

	var cityName = document.getElementById("city-name");
	var cityPopulationElement = document.getElementById("city-population");

	var cityWorkerWageElement = document.getElementById("worker-wages");

	var cityProximityToWaterElement = document.getElementById("proximity-to-water");
	var cityProximityToCoalElement = document.getElementById("proximity-to-coal");
	var cityProximityToIronElement = document.getElementById("proximity-to-iron");

	var cityBuildFactoryDisplay = document.getElementById("build-factory-display");

	var cityNoExistingFactories = document.getElementById("no-existing-factories");
	var cityExistingFactoryDisplay = document.getElementById("existing-factory-display");

	var tickTimeout = undefined;

	var events = {
		"1781/1": {
			description: "Watt creates the steam engine; all factories are boosted as resources are easier to obtain and ship and machines can run more efficiently.",
			applyChanges: function() {
				for (var cityName in cityDefinitions) {
					cityDefinitions[cityName].proximity.water = Math.max(5, cityDefinitions[cityName].proximity.water + 0.5);
					cityDefinitions[cityName].proximity.iron = Math.max(5, cityDefinitions[cityName].proximity.iron + 0.5);
					cityDefinitions[cityName].proximity.coal = Math.max(5, cityDefinitions[cityName].proximity.coal + 0.5);
				}
			},
		},
		"1785/5": {
			description: "Edmund Cartwright built and developed the flying shuttle, a massive boost to textile factories.",
			applyChanges: function() {
				factoryTypes.textile.demand *= 1.8;
			},
		},
		"1799/7": {
			description: "The British Parliament passes the Combination Acts, disallowing the formation of worker's unions in England.  This serves to decrease wages within the country.",
			applyChanges: function() {
				cityDefinitions.manchester.wages *= 0.85;
				cityDefinitions.birmingham.wages *= 0.85;
				cityDefinitions.bristol.wages *= 0.85;
				cityDefinitions.london.wages *= 0.85;
			},
		},
		"1804/4": {
			description: "Steam locomotive and internal combustion engines developed.  These advancements in transportation encouraged increased trade and allowed for increased transportation of raw materials and resources.",
			applyChanges: function() {
				for (var cityName in cityDefinitions) {
					cityDefinitions[cityName].proximity.water = Math.max(5, cityDefinitions[cityName].proximity.water + 0.5);
					cityDefinitions[cityName].proximity.iron = Math.max(5, cityDefinitions[cityName].proximity.iron + 0.5);
					cityDefinitions[cityName].proximity.coal = Math.max(5, cityDefinitions[cityName].proximity.coal + 0.5);
				}
			},
		},
		"1812/2": {
			description: "Anti-luddite laws in England decrease the initial investment required to build factories in Britain.",
			applyChanges: function() {
				cityDefinitions.manchester.baseFactoryCost *= 0.85;
				cityDefinitions.birmingham.baseFactoryCost *= 0.85;
				cityDefinitions.bristol.baseFactoryCost *= 0.85;
				cityDefinitions.london.baseFactoryCost *= 0.85;
			},
		},
		"1842/9": {
			description: "Newly-released Report on Sanitary Conditions by Edward Chadwick greatly reforms public awareness about living conditions.  Workers demand higher wages and better conditions.",
			applyChanges: function() {
				for (var cityName in cityDefinitions) {
					cityDefinitions[cityName].wages *= 1.25;
				}
			},
		},
	};

	function tick(doTick=true) {
		lastTick = Date.now();

		if (!paused && doTick) {
			month++;
			if (month >= 12) {
				year++;
				month = 0;
			}

			if (events.hasOwnProperty(""+year+"/"+month)) {
				alert(year + " " + MONTHS[month] + "\n" + events[""+year+"/"+month].description);
				events[""+year+"/"+month].applyChanges();
			}

			for (var cityName in cityDefinitions) {
				var city = cityDefinitions[cityName];
				for (var factoryType in city.factories) {
					var factoryDefinition = factoryTypes[factoryType];

					cash += factoryDefinition.productionPerWorker(city)*factoryDefinition.demand*city.factories[factoryType].workers-(city.wages*city.factories[factoryType].workers);

					transactions.push({
						amount: factoryDefinition.productionPerWorker(city)*factoryDefinition.demand*city.factories[factoryType].workers-(city.wages*city.factories[factoryType].workers),
						year: year,
						month: month,
						reason: factoryType+" in "+city.name+" revenue."
					});
				}
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

		cityWorkerWageElement.innerHTML = "$"+selectedCity.wages.formatCommas(2);

		var factoryCostButtons = document.querySelectorAll(".factory-cost");

		for (var i=0; i<factoryCostButtons.length; i++) {
			var factoryType = factoryTypes[factoryCostButtons[i].parentElement.getAttribute("data-factory")];

			factoryCostButtons[i].innerHTML = "$"+(factoryType.factoryCost(selectedCity)).formatCommas(2);

			if (factoryType.factoryCost(selectedCity) > cash) {
				factoryCostButtons[i].classList.add("disabled");
			} else {
				factoryCostButtons[i].classList.remove("disabled");
			}
		}

		var factoryProfits = document.querySelectorAll(".factory-profit");

		for (var i=0; i<factoryProfits.length; i++) {
			var factoryType = factoryTypes[factoryProfits[i].parentElement.getAttribute("data-factory")];

			factoryProfits[i].innerHTML = "Revenue: $"+(factoryType.productionPerWorker(selectedCity)*factoryType.demand).formatCommas(2)+"/worker/month";
		}

		Array.from(document.getElementsByClassName("transient-factory")).map(function(e) {
			e.outerHTML = "";
		});

		var existingFactories = selectedCity.factories;
		for (var factoryTypeKey in existingFactories) {
			var factory = existingFactories[factoryTypeKey];

			if (factory.number == 0) {
				continue;
			}

			var factoryType = factoryTypes[factoryTypeKey];

			var factoryWrapper = document.createElement("div");
			factoryWrapper.classList.add("transient-city");
			factoryWrapper.classList.add("transient-factory");
			factoryWrapper.setAttribute("data-factory", factoryTypeKey);
			factoryWrapper.style.border = "1px solid black";
			factoryWrapper.style.padding = "0.4em"

			var factoryName = document.createElement("p");
			factoryName.classList.add("no-margin");
			factoryName.style.fontWeight = "bold";
			factoryName.appendChild(document.createTextNode(factoryType.name + " ("+factory.number+")"));
			factoryWrapper.appendChild(factoryName);

			var factoryWorkers = document.createElement("p");
			factoryWorkers.classList.add("no-margin");
			factoryWorkers.classList.add("factory-workers")
			factoryWorkers.appendChild(document.createTextNode("Workers: "+factory.workers+"/"+(factory.workersPerFactory*factory.number)));
			factoryWrapper.appendChild(factoryWorkers);

			var factoryWages = document.createElement("p");
			factoryWages.classList.add("no-margin");
			factoryWages.classList.add("factory-wages")
			factoryWages.appendChild(document.createTextNode("Wages: $"+(selectedCity.wages*factory.workers).formatCommas(2)+"/month"));
			factoryWrapper.appendChild(factoryWages);

			var factoryProfit = document.createElement("p");
			factoryProfit.classList.add("no-margin");
			factoryProfit.classList.add("factory-profit")
			factoryProfit.appendChild(document.createTextNode("Revenue: $"+(factoryType.productionPerWorker(selectedCity)*factoryType.demand).formatCommas(2)+"/worker/month"));
			factoryWrapper.appendChild(factoryProfit);

			var factoryRealProfit = document.createElement("p");
			factoryRealProfit.classList.add("no-margin");
			factoryRealProfit.classList.add("factory-real-profit")
			factoryRealProfit.appendChild(document.createTextNode("Revenue: $"+(factoryType.productionPerWorker(selectedCity)*factoryType.demand*factory.workers).formatCommas(2)+"/month"));
			factoryWrapper.appendChild(factoryRealProfit);

			var factoryNet = document.createElement("p");
			factoryNet.classList.add("no-top-margin");
			factoryNet.classList.add("factory-net")
			factoryNet.appendChild(document.createTextNode("Net: $"+(factoryType.productionPerWorker(selectedCity)*factoryType.demand*factory.workers-(selectedCity.wages*factory.workers)).formatCommas(2)+"/month"));
			factoryWrapper.appendChild(factoryNet);

			var factoryAddWorkerButton = document.createElement("button");
			factoryAddWorkerButton.classList.add("factory-add-worker-button");
			factoryAddWorkerButton.appendChild(document.createTextNode("Add Worker"));
			factoryAddWorkerButton.appendChild(document.createElement("br"));
			factoryAddWorkerButton.appendChild(document.createTextNode("$"+selectedCity.workerCost().formatCommas(2)));

			if (selectedCity.workerCost() > cash || factory.workers >= (factory.workersPerFactory*factory.number)) {
				factoryAddWorkerButton.classList.add("disabled");
			} else {
				factoryAddWorkerButton.classList.remove("disabled");
			}

			factoryAddWorkerButton.onclick = addWorkerClick;
			factoryWrapper.appendChild(factoryAddWorkerButton);

			var factoryRemoveWorkerButton = document.createElement("button");
			factoryRemoveWorkerButton.classList.add("factory-remove-worker-button");
			factoryRemoveWorkerButton.classList.add("red-button");
			factoryRemoveWorkerButton.appendChild(document.createTextNode("Remove Worker"));
			factoryRemoveWorkerButton.appendChild(document.createElement("br"));
			factoryRemoveWorkerButton.appendChild(document.createTextNode("+$"+(selectedCity.workerCost()*.6).formatCommas(2)));

			if (factory.workers == 0) {
				factoryRemoveWorkerButton.classList.add("disabled");
			} else {
				factoryRemoveWorkerButton.classList.remove("disabled");
			}

			factoryRemoveWorkerButton.onclick = removeWorkerClick;
			factoryWrapper.appendChild(factoryRemoveWorkerButton);

			var factorySellButton = document.createElement("button");
			factorySellButton.classList.add("factory-sell-button");
			factorySellButton.classList.add("red-button");
			factorySellButton.appendChild(document.createTextNode("Sell Factory"));
			factorySellButton.appendChild(document.createElement("br"));
			factorySellButton.appendChild(document.createTextNode("+$"+(0.6*factoryType.factoryCost(selectedCity)/selectedCity.factoryCostMultiplier).formatCommas(2)));

			factorySellButton.onclick = factorySellClick;
			factoryWrapper.appendChild(factorySellButton);

			cityExistingFactoryDisplay.appendChild(factoryWrapper);
		}

		if (selectedCity.numberOfFactories() == 0) {
			cityNoExistingFactories.classList.remove("hide");
		} else {
			cityNoExistingFactories.classList.add("hide");
		}

		cashElement.innerHTML = "$"+cash.formatCommas();

		if (doTick) {
			if (dateSpeed != 0) {
				console.log("Setting timeout for "+(2000-dateSpeed)+"ms");
				tickTimeout = setTimeout(tick, 2000-dateSpeed);
			} else {
				console.log("PAUSED");
			}
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

	function factoryBuyButtonClick() {
		var city = cityDefinitions[cityParametersElement.getAttribute("data-city")];

		var factoryType = factoryTypes[this.parentElement.getAttribute("data-factory")];

		if (cash < factoryType.factoryCost(city)) {
			console.log("Ignoring factory purchase as not enough money");
			return;
		}

		cash -= factoryType.factoryCost(city);
		transactions.push({
			amount: -factoryType.factoryCost(city),
			year: year,
			month: month,
			reason: "Construction of a "+factoryType.factoryName+" in "+city.name
		});

		console.log("Charging "+factoryType.factoryCost(city));

		city.factories[factoryType.shortName].number++;
		city.factories[factoryType.shortName].workers++;

		tick(false);
	}

	function addWorkerClick() {
		var city = cityDefinitions[cityParametersElement.getAttribute("data-city")];
		var factoryType = this.parentElement.getAttribute("data-factory");

		if (city.workerCost() > cash || city.factories[factoryType].workers >= (city.factories[factoryType].workersPerFactory*city.factories[factoryType].number)) {
			return;
		}

		cash -= city.workerCost();
		transactions.push({
			amount: -city.workerCost(),
			year: year,
			month: month,
			reason: "Hiring of a worker for "+factoryTypes[factoryType].factoryName+" in "+city.name
		});
		city.factories[factoryType].workers++;

		tick(false);
	}
	function removeWorkerClick() {
		var city = cityDefinitions[cityParametersElement.getAttribute("data-city")];
		var factoryType = this.parentElement.getAttribute("data-factory");

		if (city.factories[factoryType].workers == 0) {
			return;
		}

		cash += city.workerCost()*0.6;
		transactions.push({
			amount: city.workerCost()*0.6,
			year: year,
			month: month,
			reason: "Firing of a worker for "+factoryTypes[factoryType].factoryName+" in "+city.name
		});
		city.factories[factoryType].workers--;

		tick(false);
	}
	function factorySellClick() {
		var city = cityDefinitions[cityParametersElement.getAttribute("data-city")];
		var factoryType = this.parentElement.getAttribute("data-factory");

		if (city.factories[factoryType].number == 1 && city.factories[factoryType].workers > 0) {
			alert("You must remove all workers before you can sell this factory.");
			return;
		}

		cash += 0.6*factoryTypes[factoryType].factoryCost(city)/city.factoryCostMultiplier;
		transactions.push({
			amount: city.workerCost()*0.6,
			year: year,
			month: month,
			reason: "Selling of a "+factoryTypes[factoryType].factoryName+" in "+city.name
		});
		city.factories[factoryType].number--;

		tick(false);
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

				cityWorkerWageElement.innerHTML = "$"+city.wages.formatCommas(2);

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

				if (city.numberOfFactories() == 0) {
					cityNoExistingFactories.classList.remove("hide");
				} else {
					cityNoExistingFactories.classList.add("hide");
				}

				for (factory in factoryTypes) {
					var factoryType = factoryTypes[factory];

					var factoryWrapper = document.createElement("div");
					factoryWrapper.classList.add("transient-city");
					factoryWrapper.setAttribute("data-factory", factoryType.shortName);
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
					factoryProfit.classList.add("factory-profit")
					factoryProfit.appendChild(document.createTextNode("Revenue: $"+(factoryType.productionPerWorker(city)*factoryType.demand).formatCommas(2)+"/worker/month"));
					factoryWrapper.appendChild(factoryProfit);

					var factoryBuyButton = document.createElement("button");
					factoryBuyButton.classList.add("factory-buy-button");
					factoryBuyButton.classList.add("factory-cost")
					factoryBuyButton.appendChild(document.createTextNode("$"+(factoryType.factoryCost(city)).formatCommas(2)));

					if (factoryType.factoryCost(city) > cash) {
						factoryBuyButton.classList.add("disabled");
					} else {
						factoryBuyButton.classList.remove("disabled");
					}

					factoryBuyButton.onclick = factoryBuyButtonClick;

					factoryWrapper.appendChild(factoryBuyButton);

					cityBuildFactoryDisplay.appendChild(factoryWrapper);
				}

				tick(false);
			};
		}
	};
	initClickableMapItems();

	tick(false);

	function endGame() {
		alert("Congratulations!  You finished the game with $"+cash.formatCommas(2)+"!");
	}
</script>
