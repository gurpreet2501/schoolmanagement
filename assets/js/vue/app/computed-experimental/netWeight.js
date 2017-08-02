window._VUE_APP_GATE_ENRTY.computed.netWeight =  function(){
	if(this.deductPackingMaterial)
		return this.grossWeight-this.packingMaterialWeight;
	return this.grossWeight;
},