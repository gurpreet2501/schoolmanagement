window._VUE_APP_GATE_ENRTY.methods = {
	forceUpdate: function(){
		this.$forceUpdate();
	},
  moduleDisplay: function (moduleID) {

   var formId = this.formId;
   var keys = [];
	   $.each(window.for_js.forms, function(key,item){
	   	  if(item.id == formId){
	   	  	$.each(item.modules, function(k,val){
	   	  		 keys.push(val.module_id);
	   	  	})
	   	  }
	   });
	 
	return keys.includes(moduleID);
  },

  updateBagTotals: function(){
		var total = 0; 
		$('.stock_item_bags').each(function(key,currentBagCount){
			var val = parseInt(currentBagCount.value);
			if(isNaN(val))
				val = 0;
			total += val;
		});
		this.stockItemBags = total;
		this.validateBagsCount();

		//Validating stock items
		if(total!=0)
			return true;
		return false;
	},
	
	updatePackingWeight: function(){
		var total = 0; 
		$('.bag_wt_update').each(function(key,currentBagCount){
			var val = parseInt(currentBagCount.value);
			if(isNaN(val))
				val = 0;
			total += val;
		});
		 console.log(total)
		this.stockItemBags = total;
		this.packingMaterialWeight = total;
		this.validateBagsCount();
	},

	updateBagTypeTotals: function(){
		var self = this;
		var total = 0;
		var packingWeight = 0;
		$('.bag_type').each(function(key, currentBagCount){
			var val = parseFloat(currentBagCount.value);
			var weight = parseFloat($(currentBagCount).attr("data-weight"));
			if (isNaN(val))
				val = 0;
			
			packingWeight += (val*weight);
			total += val;
		});
		
		this.packingMaterialWeight = packingWeight.toFixed(2);
		self.bagTypeBags = total;
		this.validateBagsCount();
		
		// Validating bag types
		if(total!=0)
			return true;

 		return false;
	},

 	qualityCutTotal: function(qc){
 		var qtyName = CSS.escape('quality_cut['+qc+'][qty_per_bag]');
 		var qtyPerBag = $('input[name='+qtyName+']').val()

 		var bagName = CSS.escape('quality_cut['+qc+'][bags]');
 		var bags = $('input[name='+bagName+']').val()
 		if(isNaN(qtyPerBag))
 			qtyPerBag = 0;

 		if(isNaN(bags))
 			bags = 0;

		return bags*qtyPerBag;
	},


	validateBagsCount: function(){
		// return;
		var self = this;
		if (self.deductPackingMaterial === false)
			return;
		var error = '';
		if ((self.stockItemBags !== self.bagTypeBags && self.bagTypeBags !== 0))
			error = 'Bag Type.';	
		
		if (self.stockItemBags < self.qualityCutBags)
			error = 'Quality cut total.';

		if (self.stockItemBags !== self.laborAllocationBags)
			error = 'Godown & Labour Allocation.';

		if (error !== ''){
			$('.error-container').text('Invalid number of Bags in ' +  error).slideDown();
			$("#submit-btn button").attr("disabled", true);
		}else{
			$('.error-container').slideUp();
			$("#submit-btn button").removeAttr("disabled");
		}
	},


	updateGodownAndLabourAllocation: function(){
		var bags = parseFloat($('.ge_godown_labor_allocation_bags').val());		
		if (isNaN(bags))
			bags = 0;
		this.laborAllocationBags = bags;
		this.validateBagsCount()
	},


	addGodownAllocation: function(){
		var lastEle = this.godownAllocations[this.godownAllocations.length-1];
		this.godownAllocations.push(lastEle+1);
	},

	deleteGodownAllocation: function(id){
		if(this.godownAllocations.length <= 1)
			return alert('Cannot delete there should be at-least one allocation.')
		this.godownAllocations.splice(this.godownAllocations.indexOf(id), 1);
	},

	addQualityCutRow: function(){
		var lastEle = this.qualityCutslist[this.qualityCutslist.length-1];
		this.qualityCutslist.push(lastEle+1);
	},

	deleteQualityCutRow: function(id){
		if(this.qualityCutslist.length <= 1)
			return alert('Cannot delete there should be at-least one entry.');
		this.qualityCutslist.splice(this.qualityCutslist.indexOf(id), 1);
	},


	validateSubmit: function (e){
		e.preventDefault();
		var $submitBtn = $('.submit-entry');
		$submitBtn.prop( "disabled", true );


		var firstWeightValidation = {
			debug:false,
			ignore: ['.ge__module input',
					'.ge__module input[type=number]',
					'.ge__module select',
					'.ge__module textarea'].join(','),
			rules: {
				party_id: "required",
				truck_no: "required",
				loaded_weight: "validate_loaded_weight",
				tare_weight: "validate_tare_weight",
			}
		};

		var rules = null;
		if(!v('isUpdate'))
			rules = firstWeightValidation;
		

		$(".gate-entry-form").validate(rules);

		var valid = $(".gate-entry-form").valid();

		if(!valid)
			return $submitBtn.prop( "disabled", false );
		
		$(".gate-entry-form").submit();
	},

	moduleConfig: function(module){
		var form = Store.query('forms')
			 			.find(this.formId);
			 	 
		return Store.query(form.modules)
					 .where('module_id',module)
					 .first();
	},

	moduleStockItems: function(module){
		 	
		var stockGroups = this.moduleConfig(module).stock_groups;
		 if(module = 'bag_types')

		var stockItems = [];
		$.each(stockGroups ,function(key, group){

			if(group.stock_items)
				stockItems = stockItems.concat(group.stock_items);

		});	

		return stockItems;
	},

	modulePartyJobtypes: function(module, partyIdColumn){
		var jobCats = this.moduleConfig(module).labour_job_categories;

		var partyId = this[module][partyIdColumn];

    	partiesWithJobTypes = window.for_js.labour_parties_with_job_types;

    	var JobTypes = [];

    	$.each(partiesWithJobTypes, function(key, labourPrty){
    		if(partyId == labourPrty.id){
    			JobTypes = labourPrty.labor_party_job_types;
    		}
     		
    	});
    	 
		return JobTypes;
	},

	moduleStockGroups: function(module){
		return  this.moduleConfig(module).stock_groups;
	},

	bagTypeTotal:function(){
		 console.log(bagTypesCount)
	},

	bagTypeStockItems: function(module){
		return  this.moduleConfig(module).stock_items;
	},

	moduleQCTypes: function(module){
		return this.moduleConfig(module).quality_cut_types;		
	}


};