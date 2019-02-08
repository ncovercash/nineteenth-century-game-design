{
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
		demand: 40
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
		demand: 40
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
		demand: 40
	}
}