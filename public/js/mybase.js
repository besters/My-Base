$(document).ready(function(){

  // Spravne zobrazeni menu
  $('ul.subnavigation li > a').wrapInner('<span></span>');
    
  // Vyberovy blok pri pridavani ACL
  $("#userSelect").multiSelect({
    selectAll: false
  });
    
  // Nastaveni modaloveho okna
  $('.modal').modal({
    opacity: 0.6,
    bgColor: '#fff'
  });
    
  //$.modal('<div class="ano">allreadyimplemented</div>');
    
  // Inicializace tooltipu
  $('*[title]').tooltip();
	 
  // Hromadne oznacovani a odznacovani checkboxu
  $("input[name='company[]']").click(function(){
    $(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
  });

	
  // Zvyrazneni aktualniho prvku ve formulari ------------------------------
  $('input:not(:checkbox), select, textarea').focusin(function(){
    $(this).parents('div.input').addClass('hover');
    $(this).parents('div.error').removeClass('hover');
		
    $('input:checkbox').parents('div.input').removeClass('hover');
  });
	
  $('input:checkbox').click(function(){
    $(this).parents('div.input').addClass('hover');
    $(this).parents('div.error').removeClass('hover');
  });
	
  $('input:not(:checkbox), select, textarea').focusout(function(){
    $(this).parents('div.input').removeClass('hover');
  });
	
  $('input::submit').focusin(function(){
    $(this).parents('div.input').removeClass('hover');
  });
  // -------------------------------------------------------------------------
	 
  // Ajaxova editace ACL -------------------------------------------------------------------------------------------------------------------
  $('.acl.modalwin label').live('mouseup', function(event){
    var label = $(this).attr('for');
    var radio = $('#'+label);
    var prev = $("input[name='" + radio[0].name + "']:checked");
		
    if ($(radio).is(':checked') == false) {
      $.ajax({
	type: "POST",
	url: "edit/" + $('span#idacl').html(),
	data: ({
	  perm: radio[0].id
	  }),
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
    yearRange: '-5:+10',
    altField: '#datetime',
    altFormat: 'yy-mm-dd',
    onSelect: function(dateText, inst) {
      $('#check').attr('value', dateText);
    }
  });
  // ---------------------------------------------------------------------------------

  // Validace formulare ---------------------------------------------------------------
  $('input, textarea, select').focusout(function(){
    var id = $(this).attr('id');

    var url = document.URL+'?validate';
    var data = {};
    $("input, textarea, select").each(function()
    {
      data[$(this).attr('name')] = $(this).val();
    });

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: 'json',
      success: function(resp){
	$("#"+id).parent().removeClass('error');
	$("#"+id).parent().find('.errors').remove();
	$("#"+id).parent().append(getErrorHtml(resp[id], id));
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
	alert(errorThrown);
      }
    });
  });

  function getErrorHtml(formErrors , id){
    if(formErrors){
      $("#"+id).parent().addClass('error');
    }

    var o = '<ul id="errors-'+id+'" class="errors">';

    for(errorKey in formErrors){
      o += '<li>' + formErrors[errorKey] + '</li>';
    }
    o += '</ul>';
    return o;
  }
  // ---------------------------------------------------------------------------------

});