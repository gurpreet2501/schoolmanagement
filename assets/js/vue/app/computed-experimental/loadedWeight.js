window._VUE_APP_GATE_ENRTY.computed.loadedWeight = function(){
	if((this.entryType=='IN') && !v('isUpdate'))
		return this.comWeight;
	if((this.entryType=='OUT') && v('isUpdate'))
		return this.comWeight;
	if(v('isUpdate'))
		return v('gate_entry').loaded_weight; 
	return 0;
};