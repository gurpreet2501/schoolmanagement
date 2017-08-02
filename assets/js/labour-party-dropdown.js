jQuery(function($){
    var options = [];
	$("#choose-category option").each(function(key, record){
	     options[record.value] = record.text;
	});
  var ids = [];
  $('#choose-category').change(function(){
  	if(window.CREATE_LABOUR_PARTY){
  		window.CREATE_LABOUR_PARTY.cat_id = $(this).val();
       if($(this).val() == null)
        window.CREATE_LABOUR_PARTY.cat_id = [];
  	}
  })
})