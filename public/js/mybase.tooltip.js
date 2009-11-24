;(function($) {
	
	$.tooltip = function (data, options) {
		return $.tooltip.main.init(data, options);
	};
	
	$.fn.tooltip = function(options){
		return this.each(function() {			
			$.tooltip.main.init(this, options);
		});
	};
	
	$.tooltip.main = {	
			
		init: function(element, options){		
			$(element).hover(function(e){
				tooltip = $(element).attr("title");
				$.tooltip.main.show(element, tooltip, e);
				$.tooltip.main.move(element);
			}, function(){ // mouseOut
				$.tooltip.main.hide(element, tooltip);
			});							
		},
		
		create: function(tooltip){
			$('body').append('<div id="tooltip" style="display: none; position: absolute">'+tooltip+'</div>');
		},
		
		show: function(element, tooltip, e){			
			 $.tooltip.main.create(tooltip);
			 $('#tooltip').css({left: e.pageX + 10, top: e.pageY + 20}).fadeIn(100).fadeTo('slow', 0.7);
			
			$(element).attr("title", "");			
		},
		
		hide: function(element, tooltip){
			$(element).attr("title", tooltip);
			$('#tooltip').remove();
		},
		
		move: function(element){
			$(element).mousemove(function(e){
				$('#tooltip').css({left: e.pageX + 10, top: e.pageY + 20}).fadeIn(100);
			});
		}
	};	  
	
})(jQuery);