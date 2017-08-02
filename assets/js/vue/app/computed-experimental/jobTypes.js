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