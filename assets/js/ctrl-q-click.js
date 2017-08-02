
Mousetrap.bind('ctrl+q', function(e) {
	$('.ctrl_q_click').each(function(){
		var $ele = $(this);
		var $area = $($ele.attr('data-ctr_q_area_selector'));
		if(!$area.length)
			return;
		if($area.find(':focus').length)
			$ele.trigger('click');
	});
});


