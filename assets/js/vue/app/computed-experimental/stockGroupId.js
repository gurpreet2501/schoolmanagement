stockGroupId: function(){
		var form = Store.query('forms')
					.find(this.formId);
		if(!form)
			return 0;
		return form.stock_group_id;
	},