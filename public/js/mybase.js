$(document).ready(function(){

	$('li > a').wrapInner('<span></span>');
	
	$("#userSelect").multiSelect({selectAll: false});   
		   
	$('.modal').modal({opacity: 0.6, bgColor: '#fff'});			   
	//$.modal('<div class="ne">not implemented</div>');
	
	$('*[title]').tooltip({top: 20, left: 10});

});