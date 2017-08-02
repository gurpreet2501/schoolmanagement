forms: function(){
		var self = this;
		var filtered = $.grep(window.for_js.forms,function(item){
			return (self.entryType == item.type)
		});
		return filtered;
	},