window._VUE_APP_GATE_ENRTY.watch = {
	//reset the formId to zero 
	entryType: function (newEntryType) {
		this.formId = 0;	  
	},

	formId: function (newFormId) {
		this.qualityCutslist = [];	  
		this.qualityCutslist = [0];	  
		this.godownAllocations = [];  
		this.godownAllocations = [0];
	},

	accountId: function(newAccountId){
		this.cmrDetails.accountId = newAccountId;
	},

	truckNo: function(newTruckNum){
		this.cmrDetails.truckNo = newTruckNum;	
	}
};