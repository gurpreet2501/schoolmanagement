jQuery.validator.addMethod("validate_tare_weight", function(value, element,params) {
	if(window.GATE_ENTRY.entryType == 'OUT')
		return jQuery.validator
					.methods
					.required
					.call(this,value, element,params);
	return true;
}, "Tare weight is required.");