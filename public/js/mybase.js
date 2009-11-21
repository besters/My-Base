$(document).ready(function(){

	$('li > a').wrapInner('<span></span>');
	
	 $("#userSelect").multiSelect({selectAll: false}); 
			 
		// pohybuje s prvkem tooltip při pohybu myši
		   $(document).mousemove(function(e){
		      $('#supertitle').css({top:e.pageY-5,left:e.pageX+15});
		   }); 
		 
		// po najetí myši na odkaz  
		   $('*[title]').mouseover(function(e){                 // po najetí myší na odkaz s title
		      $(this).after('<div id="supertitle"></div>');        // přidá za něj DIV s ID tooltip
		      var ttext = $(this).attr("title");                // uloží title do proměnné
		      $(this).attr({title:""});                         // vymaže title (aby se nezobrazovala klasická windwos)
		      $('#supertitle').text(ttext).show().fadeTo(800,0.8); // zobrazení a něco pro efekt :-)
		   }); 
		 
		   $('*[title]').mouseout(function(e){                 // po odjetí myší z odkazu s title
		      $(this).attr({title:$('#supertitle').text()});      // zapíše atribut title zpátky k odkazu (aby jej bylo možno znovu použít)
		      $('#supertitle').hide().remove();                    // skryje DIV s ID tooltip a potom ho odstraní
		   }); 
});
