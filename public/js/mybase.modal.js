;(function($) {
	
	// $.modal('neni implementovano zatim');
	$.modal = function (data, options) {
		return $.modal.main.init(data, options);
	};
	
	// $('#prvek').modal({option: 'value', ...});
	$.fn.modal = function(options){
		$(this).unbind('click.modal').bind('click.modal', function (e) {
			return $.modal.main.init(this, options);
		});
	};
	
	$.modal.defaults = {
		bgColor:	'#fff',
		opacity:	0.6,
		overlay:	true,
		close:		'.close',
		loadingImg: '/public/design/loader.gif',
		closeText:	'Close'
	};
	
	$.modal.main = {	
			
		init: function(element, options){
		
			cfg = $.extend({}, $.modal.defaults, options);
			
			$.modal.main.binds();		
					
			$.modal.main.contentSwitch(element);
				
			return false;
		},
		
		fill: function(data){		
			$('#modal .content').empty().append(data);
			$('#modal .loading').remove();
			$('#modal .body').children().fadeIn('normal');			
			$('#modal').css('left', ($(window).width() - $('#modal table').outerWidth(true)) / 2);
		},
		
		overlay: function(data){
			if(cfg.overlay == false) return;
			$('body').append('<div id="modal-overlay"></div>');
			$('#modal-overlay').hide();
			$('#modal-overlay').css({'opacity': cfg.opacity, 'background-color': cfg.bgColor}).fadeIn(200);	
		},
		
		modal: function(data){
			$.modal.main.overlay();
			
			$('#modal').remove();
			$('body').append('<div id="modal"><div class="body"><div class="content"></div><a href="#" class="close">'+cfg.closeText+'</a></div></div>');			
			$('#modal').hide();				
			$('#modal .body').children().hide().end().append('<div class="loading"><img src="'+cfg.loadingImg+'" /></div>');			
			$('#modal').css({top:	getPageScroll()[1] + (getPageHeight() / 10), left: ($(window).width() - $('#modal').outerWidth(true)) / 2}).fadeIn(200);
		},
		
		contentSwitch: function(data){
			$.modal.main.modal();
			
			$.modal.main.contentAjax(data);
			//$.modal.main.contentSimple(element);
			//$.modal.main.contentImage(element);
			//$.modal.main.contentTarget(element);			
		},
		
		contentAjax: function(href){
			$.get(href, function(data) { $.modal.main.fill(data); });	
		},
		
		contentSimple: function(data){
			$.modal.main.fill(data);
		},
		
		contentImage: function(data){
			//todo
		},
		
		contentTarget: function(data){
			//todo
		},
			
		close: function(){
			$(document).unbind('keydown.modal');	
			
			$('#modal').fadeOut(function(){
				$('#modal').remove();					
			});		
			
			$('#modal-overlay').fadeOut(function(){
				$('#modal-overlay').remove();
			});
		},
		
		binds: function(){	
			$(document).unbind('keydown.modal').bind('keydown.modal', function(e) {
				if (e.keyCode == 27) $.modal.main.close();	
				return true;
			});
			
			$(cfg.close).live("click", function(){
				$.modal.main.close();
			});
		}			
	};	
	
	
  // getPageScroll() by quirksmode.com
  function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;	
    }
    return new Array(xScroll,yScroll);
  }

  // Adapted from getPageSize() by quirksmode.com
  function getPageHeight() {
    var windowHeight;
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }	
    return windowHeight;
  }	
  
	
})(jQuery);