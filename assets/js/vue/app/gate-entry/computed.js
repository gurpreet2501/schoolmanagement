window._VUE_APP_GATE_ENRTY.computed = {
	netWeight:  function(){
		if(this.deductPackingMaterial)
			return this.grossWeight-this.packingMaterialWeight;
		return this.grossWeight;
	},
	grossWeight: function(){
		 console.log(this.loadedWeight)		
		if(this.loadedWeight && this.tareWeight)
			return this.loadedWeight-this.tareWeight;
		// return 0;
	},


	__loadedWeight: function(){
		if((this.entryType=='IN') && !v('isUpdate'))
			return this.comWeight;
		if((this.entryType=='OUT') && v('isUpdate'))
			return this.comWeight;
		if(v('isUpdate'))
			return v('gate_entry').loaded_weight; 
		// return 0;
	},

	__tareWeight: function(){
		if((this.entryType=='OUT') && !v('isUpdate'))
			return this.comWeight;
		if((this.entryType=='IN') && v('isUpdate'))
			return this.comWeight;
		if(v('isUpdate'))
			return v('gate_entry').tare_weight; 
		// return 0;
	},

	forms: function(){
		var self = this;
		var forms = Store.query('forms')
						 .where('type',self.entryType)
						 .get();
		return forms;
	},


	jobTypes: function(){
		var self = this;
		var laboutJobTypes = [];
		var filtered = $.grep(window.for_js.labour_parties_with_job_types, function(item){
			if(self.labourParty == item.id){
				laboutJobTypes = item.labour_job_types;
			}
		});
		return laboutJobTypes;
	},	

	formsDisplay: function(){
		return Boolean(this.entryType);
	},

};