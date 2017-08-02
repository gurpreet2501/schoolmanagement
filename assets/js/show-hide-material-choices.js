jQuery(function(){
		//Hiding all modules on start up
		 
		var operations = {
		 	'hideAllModules' : function(){
		 		return;
		 	 	 $('#bag_type').hide();
				 $('#material_type').hide()
				 $('#quality_cut').hide();
				 $('#godown_and_labour_allocation').hide();
				 $('#godown_material_qc_labour_allocation').hide();
				 $('#cmr_details').hide();
				 $('#cmr_rice_delivery_details').hide();
				 $('#common-fields').hide();
				 $('#submit-btn').hide();
		 	}
		 };

		 operations.hideAllModules();	     
     $('#material-in').hide();	
     $('#material-out').hide();	
	   
	   $('.material-filters').change(function() {
	   		 $('#common-fields').show();
				 $('#submit-btn').show();
	   	   var val = $(this).val();
	   	   if(val == 'materialIN'){
	   	   		$('#material-in').show();
	   	   		$('#material-out').hide();	
	   	   }else{
	   	   	$('#material-in').hide();
	   	   		$('#material-out').show();
	   	   }
    });

	  $('.material-choices').change(function() {
	  		operations.hideAllModules();	
	  	 	 $('#common-fields').show();
				 $('#submit-btn').show();
	   	   var selectedMaterialTypeId = $(this).val();
	  	   $.each(window.for_js[0], function(key,values){
	  	   		$.each(values, function(inKey,val){
	  	   				if(selectedMaterialTypeId == key)
	  	   			  { 
	  	   			  	$('#'+val).show();
	  	   			  }

	  	   		})		
	  	   })

    });

	  


});