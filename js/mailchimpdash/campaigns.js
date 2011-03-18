function expand(dom) 
{
	var ele = $(dom);
	var body = ele.parent('.campaign-header-right').parent('.campaign-header').parent('.campaign').find('.campaign-body');
	body.slideToggle(100);
	if (ele.css('background-image').match(/minus/)) {
		ele.css('background-image', ele.css('background-image').replace(/minus/, 'plus'));
	} else {
		ele.css('background-image', ele.css('background-image').replace(/plus/, 'minus'));
	}
}