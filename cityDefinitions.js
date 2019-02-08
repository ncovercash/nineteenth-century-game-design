{
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
					return 5012843 + 47939.9*decadeYear;
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
}