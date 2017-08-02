jQuery.validator.addMethod("stockitems", function(value, element) {
	return Boolean(parseInt($.trim($('.material_type_total').text())));
}, "Please enter atleast one stock item.");