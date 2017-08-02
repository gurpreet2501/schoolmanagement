jQuery(function( $ ){


	(function(){
		var addPage = (window.location.href).endsWith('/manager_dashboard/machinery_parts/add');
		if (addPage){
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			if(dd<10)
    			dd='0'+dd;
			if(mm<10)
			    mm='0'+mm;
			
			var today = dd+'/'+mm+'/'+yyyy;

			$("#field-date").val(today);
		}
	})();


	// add cash transaction page
	(function(){

		if (!$('#add-cash-transaction').length){
			return;
		}

		$('form').validate();
		$( '.from_date, .to_date' ).datepicker({ dateFormat: 'yy-mm-dd' });
	})();


	(function(){
		var loaded = false;
		$('#gate-entry').on("click", "#tp_date, #ac_note_date", function(){
			loaded = true;
			$( this ).datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$( this ).datepicker('show');
		});
	})();

	// add rate contracts page
	(function(){
		if (!$('#add-rate-contracts').length){
			return;
		}

		$( '.allow-datepicker' ).datepicker({dateFormat: 'yy-mm-dd'});			
	})();

		// add rate contracts page
	(function(){
		if (!$('#transactions_report_generator').length){
			return;
		}

		$( '#to_date, #from_date' ).datepicker({dateFormat: 'yy-mm-dd'});			
	})();

	

});
