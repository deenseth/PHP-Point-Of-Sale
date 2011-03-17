function thickit(dom)
{
	var t = dom.title || dom.name || null;
	var a = dom.href || dom.alt;
	var g = dom.rel || false;
	tb_show(t,a,g);
	dom.blur();
	return false;
}

$(document).ready(function(){
	
	$('#lists-buttons .button').click(function(){
		
		var id = $(this).attr('id').replace(/button_/, '');
		
		var url = document.location.href.replace(/#/, '') + 'ajax';
		
		var imageurl = document.location.href.replace(/index\.php\/mailchimpdash\/lists/, '');
		
		var lv = $('#lists-view');
		
		if (lv.is(':hidden')) {
		
			lv.slideDown(1000, function() {
				lv.load(url, {listid: id});
			});
			
		} else {
			
			lv.slideUp(1000, function() {
				lv.html('<div id="lists-loading"><img id="lists-loading" src="'+imageurl+'images/spinner_small.gif" /></div>');
				lv.load(url, {listid: id});
				lv.slideDown(1000);
			});
						
			
		}
		
		return false;
	});
	
});