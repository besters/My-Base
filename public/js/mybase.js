$(document).ready(function(){
    
    $('li > a').wrapInner('<span></span>');
    
    $("#userSelect").multiSelect({
        selectAll: false
    });
    
    $('.modal').modal({
        opacity: 0.6,
        bgColor: '#fff'
    });
    
    //$.modal('<div class="ne">not implemented</div>');
    
    $('*[title]').tooltip();
	 
	
	$('.acl.modalwin label').live('mouseup', function(event){
		var label = $(this).attr('for');
		var radio = $('#'+label);

		var prev = $("input[name='" + radio[0].name + "']:checked");
		
		if ($(radio).is(':checked') == false) {
			$.ajax({
				type: "POST",
				url: "edit/" + $('span#idacl').html(),
				data: ({perm: radio[0].id}),
				beforeSend: function(XMLHttpRequest){
					$(radio).after('<img src="/public/design/loader-input.gif" id="acl-spinner" style="margin: 0 4px 0 0; padding: 0" />');
					$(radio).hide();
				},
				success: function(data){
					$(radio).attr('checked', true);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					$(radio).removeAttr("checked");
					$('#' + prev[0].id).attr('checked', true);
					$(radio).blur();
				},
				complete: function(){
					$(radio).show();
					$('#acl-spinner').remove();
				}
			});
		}
		
	});

});
