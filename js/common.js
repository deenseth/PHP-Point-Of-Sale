$(document).ready(function()
{
	var message = JSON.parse(window.localStorage.getItem("message"));
	if(message != null)
	{
		set_feedback(message.text, message.type, false);
		window.localStorage.removeItem("message")
	}
});

function thickit(dom)
{
	var t = dom.title || dom.name || null;
	var a = dom.href || dom.alt;
	var g = dom.rel || false;
	tb_show(t,a,g);
	dom.blur();
	return false;
}

function get_dimensions() 
{
	var dims = {width:0,height:0};
	
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    dims.width = window.innerWidth;
    dims.height = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    dims.width = document.documentElement.clientWidth;
    dims.height = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    dims.width = document.body.clientWidth;
    dims.height = document.body.clientHeight;
  }
  
  return dims;
}

function set_feedback(text, type, keep_displayed)
{
	if(!keep_displayed)
	{
		toastr.options = {
		  "extendedTimeOut": "1000"
		}
	}

	if(type == 'success')
	{
		toastr.success(text);
	}else if(type == 'error'){
		toastr.error(text);
	}else if(type == 'warning'){
		toastr.warning(text);
	}else{
		toastr.info(text);
	}
}

//keylisteners

$(window).jkey('f1',function(){
window.location =  SITE_URL + '/customers/index';
});


$(window).jkey('f2',function(){
window.location =  SITE_URL + '/items/index';
});


$(window).jkey('f3',function(){
window.location =  SITE_URL + '/reports/index';
});

$(window).jkey('f4',function(){
window.location =  SITE_URL + '/suppliers/index';
});

$(window).jkey('f5',function(){
window.location =  SITE_URL + '/receivings/index';
});


$(window).jkey('f6',function(){
window.location =  SITE_URL + '/sales/index';
});

$(window).jkey('f7',function(){
window.location =  SITE_URL + '/employees/index';
});

$(window).jkey('f8',function(){
window.location =  SITE_URL + '/config/index';
});

$(window).jkey('f9',function(){
window.location =  SITE_URL + '/giftcards/index';
});
