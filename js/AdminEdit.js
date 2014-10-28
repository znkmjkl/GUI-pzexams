$(function () {
 
    $("#add").click(function() {
       
       val = $('#add_domain').val();
        
       listitem_html = '<li>';
       listitem_html += val;
       listitem_html += '<input type="hidden" name="domains[]" value="' + val + '" /> ';
       listitem_html += '<a href="#" class="remove_domain">Usuń</a>'
       listitem_html += '</li>';
       
        $('#domainsList').append(listitem_html);

		$( ".remove_domain" ).bind('click', function(e) {
			e.preventDefault();
			$(this).parent().remove();
		});
        
    });
    
    $('.remove_domain').on('click', function(e) {

		e.preventDefault();
		$(this).parent().remove();
    });

	$.toggleShowPassword = function (options) {
        var settings = $.extend({
            field: "#password",
            control: "#toggle_show_password",
        }, options);

        var control = $(settings.control);
        var field = $(settings.field)

        control.bind('click', function () {
            if (control.is(':checked')) {
                field.attr('type', 'text');
            } else {
                field.attr('type', 'password');
            }
        })
    };
    
	$.toggleShowPassword({
		field: '#code',
		control: '#code2'
	});
	$.toggleShowPassword({
		field: '#password',
		control: '#pass2'
	});

});
