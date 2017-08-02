Vue.component('qc-row', {
	template: v('qcRowTemplate'),
	props: ['rowId'],
  data: function(){
		return {
			qc_quantity:0,
			cutUnit:'',
			unit_count:0,
			total: 0
		};
  },
  methods: {
		updateTotal:function()	{
			this.total = this.qc_quantity * this.unit_count;
			return this.total;
		},
		deleteRow:function(rowId)	{
			this.$emit('delete',rowId);
		},
	}
});

new Vue({
el: '#ge_delievery',

data: {
	geDelieveryQc:[0],
	weight:0,
	wtDifference:0,
	
},

computed:{
	unitCount:function()	{
		if(this.cutUnit == 'BAG')
			return 'No of Bags';
		else
    	return 'Quintals';
	},
	
},

methods: {
	
	updateTotal:function()	{
		this.total = this.qc_quantity * this.unit_count;
		return this.total;
	},

	calcWtDiff:function()	{
		return this.wtDifference = window.for_js.gateEntry.loaded_weight - this.weight
	},

	addGeDeleieveryQc: function(){
		var lastEle = this.geDelieveryQc[this.geDelieveryQc.length-1];
		this.geDelieveryQc.push(lastEle+1);
	},

	deleteGeDelieveryQc: function(id){
		if(this.geDelieveryQc.length <= 1)
			return alert('Cannot delete there should be at-least one allocation.')
		this.geDelieveryQc.splice(this.geDelieveryQc.indexOf(id), 1);
	},

}

});

