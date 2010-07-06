;(function($) {

    $.tabs = function (data, options) {
        return $.tabs.main.init(data, options);
    };

    $.fn.tabs = function(options){
        return $.tabs.main.init(this, options);
    };

    $.tabs.defaults = {
        loadingImg: '/public/design/loader.gif'
    };

    $.tabs.main = {
        init: function(element, options){
            cfg = $.extend({}, $.tabs.defaults, options);

            var link = $(element).children().children('li').children('a');

            $.tabs.main.prepare(link);

            return false;
        },

        prepare: function(link){  

            $(link).unbind('click.tab').bind('click.tab', function (e) {
                $.tabs.main.removeActive(link);
                $.tabs.main.setActive(this);                
                $.tabs.main.ajax(this);
            });

            $.tabs.main.setActive(link[0]);
            $.tabs.main.ajax(link[0]);
        },

        ajax: function(element){
            var href = $(element).attr('rel');

            $.ajax({
                url: href,
                beforeSend: function(){
                    $(element).parent().parent().parent().append('<div id="tabs-loading"><img src="'+cfg.loadingImg+'" /></div>');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert(errorThrown);
                },
                success: function(data) {
                    $.tabs.main.fill(data, element);
                },
                complete: function(){
                    $('#tabs-loading').remove();
                }
            });
        },

        fill: function(data, element){
            var ul = $(element).parent().parent().parent();
            
            $('#tabs-data').remove();

            $(ul).append('<div id="tabs-data">'+data+'</div>');
        },

        setActive: function(element){
            $(element).addClass('selected');
            $(element).parent().addClass('selected');
        },
        
        removeActive: function(element){
            $(element).removeClass('selected');
            $(element).parent().removeClass('selected');
        }
    };

})(jQuery);