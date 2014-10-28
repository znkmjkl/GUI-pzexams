$("#contactForm").validate({
	errorElement: 'span',
	rules: {
		subject: "required",
		message: "required",
		surname: "required",
		captcha_code: {
			required: true,
			minlength: 6,
			maxlength: 6
		},
		email: {
			required: true,
			email: true
		}
	},
	messages: {
		subject: "Proszę podać temat.",
		message: "Proszę wpisać treść wiadomości.",
		surname: "Proszę wpisać imię i nazwisko.",
		captcha_code: {
			required: "Proszę przepisać kod z obrazka.",
			minlength: "Wpisano nieprawidłową ilość znaków."
		},
		email: {
			required: "Proszę podać kontaktowy adres e-mail.",
			email: "Podany adress nie jest prawidłowym adresem e-mail."
		}
	},
	//odpowiedzialne za umieszcenie komunikatu wewntrz odpowiedniego element
	//o id [element]-error-message, gdzie [element] jest podany jako parametr funkcji
	errorPlacement: function(error, element) {
		var name = $(element).attr("name");
		if(error.length){
			$("#" + name + "-error-message").append("<span class=\"badge pull-left\" style=\"background-color:#F13333;\">!</span>");
			error.appendTo($("#" + name + "-error-message"));
			$("#" + name + "-error-message").children("span").eq(1).css(
			{
				padding: '5px',
				color: '#B94A48'
			});
		}else{
			$("#" + name + "-error-message").empty();
		}
	},

	//usun komunikat bledu - potrzebne aby zniknal wykrzyknik
	success: function(element) {
		element.parent().empty();
	}
});
