window._VUE_APP_GATE_ENRTY.computed.grossWeight = function(){
	if(this.loadedWeight && this.tareWeight)
		return this.loadedWeight-this.tareWeight;
	return 0;
};