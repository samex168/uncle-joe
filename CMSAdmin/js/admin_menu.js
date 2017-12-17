$(document).ready(function() {
	$('#menu > li > a').click(function(e) {
		$(this).parent().parent().find('.selected').removeClass('selected');
		$(this).parent().addClass('selected');
		if($(this).parent().find(" > ul").length>0){
			e.preventDefault();
			e.stopPropagation;
			$(this).parent().find(" > ul").slideToggle();
		}
	});
});