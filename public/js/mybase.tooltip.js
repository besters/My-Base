;(function($) {
	
	$.tooltip = function (data, options) {
		return $.tooltip.main.init(data, options);
	};
	
	$.fn.tooltip = function(options){
		return this.each(function() {			
			$.tooltip.main.init(this, options);
		});
	};
	
	$.tooltip.defaults = {
		left:	10,
		top:	20
	};
	
	$.tooltip.main = {	
			
		init: function(element, options){		
			cfg = $.extend({}, $.tooltip.defaults, options);

			$(element).hover(function(e){
				tooltip = $(element).attr("title");
				$.tooltip.main.show(element, tooltip, e);
			}, function(){ // mouseOut
				$.tooltip.main.hide(element, tooltip);
			});	
			
			$.tooltip.main.move(element);			
		},
		
		create: function(tooltip){
			$('body').append('<div id="tooltip" style="display: none; position: absolute">'+tooltip+'</div>');
		},
		
		show: function(element, tooltip, e){
			 $.tooltip.main.create(tooltip);
			 $('#tooltip').css({left: e.pageX + cfg.left, top: e.pageY + cfg.top}).fadeIn(100).fadeTo('slow', 0.7);
			
			$(element).attr("title", "");			
		},
		
		hide: function(element, tooltip){
			$(element).attr("title", tooltip);
			$('#tooltip').remove();
		},
		
		move: function(element){
			$(element).mousemove(function(e){
				$('#tooltip').css({left: e.pageX + cfg.left, top: e.pageY + cfg.top}).fadeIn(100);
			});
		}
	};	  
	
})(jQuery);