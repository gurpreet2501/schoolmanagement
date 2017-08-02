tareWeight: function(){
		if((this.entryType=='OUT') && !v('isUpdate'))
			return this.comWeight;
		if((this.entryType=='IN') && v('isUpdate'))
			return this.comWeight;
		if(v('isUpdate'))
			return v('gate_entry').tare_weight; 
		return 0;
	}