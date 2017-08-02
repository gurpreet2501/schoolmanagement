jQuery.validator.addMethod("validate_loaded_weight", function(value, element,params) {
	if(window.GATE_ENTRY.entryType == 'IN')
		return jQuery.validator
					.methods
					.required
					.call(this,value, element,params);
	return true;
}, "Loaded weight is required.");