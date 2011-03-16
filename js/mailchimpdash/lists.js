$(document).ready(function(){
	
	$('#lists-buttons .button').click(function(){
		
		var id = $(this).attr('id').replace(/button_/, '');
		
		var url = document.location.href.replace(/#/, '') + 'ajax';
		
		var imageurl = document.location.href.replace(/index\.php\/mailchimpdash\/lists/, '');
		
		if ($('#lists-view').is(':hidden')) {
		
			
				
			$('#lists-view').slideDown(1000, function() {
				$('#lists-view').load(url, {listid: id});
			});
			
		} else {
			$('#lists-view').slideUp(1000, function() {
				$('#lists-view').html('<div id="lists-loading"><img id="lists-loading" src="'+imageurl+'images/spinner_small.gif" /></div>');
				$('#lists-view').load(url, {listid: id});
				$('#lists-view').slideDown(1000);
			});
						
			
		}
		
		return false;
	});
	
});