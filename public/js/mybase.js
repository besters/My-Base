$(document).ready(function(){
    
	 // Spravne zobrazeni menu
    $('li > a').wrapInner('<span></span>');
    
	 // Vyberovy blok pri pridavani ACL
    $("#userSelect").multiSelect({
        selectAll: false
    });
    
	 // Nastaveni modaloveho okna
    $('.modal').modal({
        opacity: 0.6,
        bgColor: '#fff'
    });
    
    //$.modal('<div class="ne">not implemented</div>');
    
	 // Inicializace tooltipu
    $('*[title]').tooltip();
	 
	// Hromadne oznacovani a odznacovani checkboxu
	$("input[name='company[]']").click(function(){
		$(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
	});
	 
	// Ajaxova editace ACL -------------------------------------------------------------------------------------------------------------------
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
	// ------------------------------------------------------------------------------------------------------------------------------------------
	
	// Zobrazeni kalendare v sekci milestones	------------------------------------------
	$.datepicker.setDefaults($.extend($.datepicker.regional['']));
				
	$("#datepicker").datepicker({ 
		changeMonth: true,
		changeYear: true,
		showOtherMonths: false,
		showMonthAfterYear: false,
		yearRange: '-1:+10',
		altField: '#datetime'
	});

	// ---------------------------------------------------------------------------------
	

	 
});
