window._VUE_APP_GATE_ENRTY.data = {
	entryType:v('isUpdate')
				? v('gate_entry').entry_type
				: '',

	formId:v('isUpdate')
				? v('gate_entry').form_id
				: 0,
				
	accounts:v('accounts'),

	accountId: v('isUpdate')
				? v('gate_entry').account_id
				: 0,

	truckNo:v('isUpdate')
				? v('gate_entry').truck_no
				: '',

	cmrDetails:{
		accountId: 0,
		truckNo:'',
	},
	
	godown_material_qc_labour_allocation:{
		labourPartyId:'null',	
	},

	stockItemBags:0,
	bagTypeBags:0,
	loadedWeight:0,
	tareWeight:0,
	qualityCutBags:0,
	laborAllocationBags:0,
	deductPackingMaterial: false,
	godownAllocations:[0],
	comWeight:0,
	packingMaterialWeight:0,
	qualityCutslist:[0],
};