var emails;
var first_names;
var last_names;
var counter = 0;

var char1 = "<";
var char2 = ">";
var separator = ",";

var emailsAdded = new Array();

// GLOBAL FUNCTIONS SECTION BEGIN *********************************************************************************************************
function go_to_stage2()
{
	var errors = new Array();

	if($('input#exam_name').val().trim() == "") {
			$('div#exam_name_group').attr('class', 'form-group has-error');
			errors[errors.length] = true;
			$('span#exam_name-error-message').remove();
			$('div#exam_name_group').append('<span class="help-block" id="exam_name-error-message"><span style="background-color:#F13333;" class="badge pull-left ">!</span>'+
				'<span style="padding:5px">Podaj nazwę egzaminu</span></span>');
			$('span#exam_name-error-message').hide();
			$('span#exam_name-error-message').fadeIn(500);
	} else if ($('input#exam_name').val().trim().length < 5 || $('input#exam_name').val().trim().length > 60){
			$('div#exam_name_group').attr('class', 'form-group has-error');
			errors[errors.length] = true;
			$('span#exam_name-error-message').remove();
			$('div#exam_name_group').append('<span class="help-block"  id="exam_name-error-message"><span style="background-color:#F13333;" class="badge pull-left ">!</span>'+
				'<span style="padding:5px">Nazwa powinna mieć od 5 do 60 znaków.</span></span>');
			$('span#exam_name-error-message').hide();
			$('span#exam_name-error-message').fadeIn(500);
	} else {
			$('div#exam_name_group').attr('class', 'form-group');
			errors[errors.length] = false;
			$('span#exam_name-error-message').remove();
	}

	if($('input#exam_duration').val() == "") {
			$('div#duration_group').attr('class', 'form-group has-error');
			errors[errors.length] = true;
			$('span#duration-error-message').remove();
			$('div#duration_group').append('<span class="help-block" id="duration-error-message"><span style="background-color:#F13333;" class="badge pull-left ">!</span>'+
				'<span style="padding:5px">Podaj czas trwania egzaminu</span></span>');
			$('span#duration-error-message').hide();
			$('span#duration-error-message').fadeIn(500);
	} else if($('input#exam_duration').val() < 5 || $('input#exam_duration').val() > 60){
			$('div#duration_group').attr('class', 'form-group has-error');
			errors[errors.length] = true;
			$('span#duration-error-message').remove();
			$('div#duration_group').append('<span class="help-block" id="duration-error-message"><span style="background-color:#F13333;" class="badge pull-left ">!</span>'+
				'<span style="padding:5px">Czas trwania egzaminu może mieć wartość od 5 do 60 min.</span></span>');
			$('span#duration-error-message').hide();
			$('span#duration-error-message').fadeIn(500);

	} else {
			$('div#duration_group').attr('class', 'form-group');
			errors[errors.length] = false;
			$('span#duration-error-message').remove();
	}

	for(var i = 0; i < errors.length; i++) {
			if (errors[i] == true) {
				return false;
			}
	}

	$('#stage1').hide(300);
	$('#stage2').show(400);

	$('li#exam_option1').css("font-weight", "bold");
	$('li#exam_option0').css("font-weight", "");

}

function back_to_stage1()
{
	$('#stage2').hide(300);

	$('#stages').append($('#stage1').show(400));

	$('li#exam_option0').css("font-weight", "bold");
	$('li#exam_option1').css("font-weight", "");
}

// GLOBAL FUNCTIONS SECTION END *********************************************************************************************************

$( document ).ready(function() {

	$('button#add_students').attr("disabled", "disabled");

	$('#stage2').hide();

	$('input#exam_duration').keyup(function () { 
		this.value = this.value.replace(/[^0-9\.]/g,'');
	});

	$('button#prev1').click(function () {
		$('#tabs a[href="#data"]').tab('show');
	});

	$('button#next1').click(function () {

		go_to_stage2();

	});

	$('button#prev2').click(function () {

		back_to_stage1();

	});

	$('li#exam_option0').click(function() {

		back_to_stage1();

	});

	$('li#exam_option1').click(function() {

		go_to_stage2();
		
	});

	$("input#exam_name").focusout( function ( event){
		if ($("input#exam_name").val().trim().length > 5 && $("input#exam_name").val().trim.length < 60) {
			$('#exam_name_group').toggleClass("has-error has-success");

			$('#exam_name-error-message').fadeOut();
		}

	});

	$('button#add_students').click( function(){

		var rep = false;

		var errorCounter = 0;
		var repetGlobalCounter = 0;

		var email_p = new RegExp("^[\\" + char1 + "]?[\\w-_\.+]*[\\w-_\.]\@([\\w]+\\.)+[\\w]+[\\w][\\" + char2 +"]?$");

		var parts = $('#student_list').val().trim().split(separator);

		if (parts != null) {

			for(var i = 0; i < parts.length; i++) {

				var repetCounter = 0;

				var elems = parts[i].trim().split(" ");

				if (parts[i].trim() != "" && parts[i] != null) {

				if (elems[elems.length-1].trim().match(email_p) != null) {

					var repThis = false;

					var emailToAppend = elems[elems.length-1].trim().replace("<", "").replace(">", "");

					emailsAdded.push(emailToAppend.trim());

					for (var g = 0; g < emailsAdded.length-1; g++) {
						if (emailToAppend.trim() == emailsAdded[g]) {
							rep = true;
							repThis = true;
						}
					}

					if (elems.length == 1) {

						if (!repThis) {
							$('table#st').css('display', '');
							$('table#st tbody').append('<tr class="student" id="' + (counter++) + '"><td id="number" style="text-align: center;">' + counter + '.</td><td id="fn">-</td><td id="ln">-</td><td id="em">' + emailToAppend.trim() + '</td><td><a title="Usuń studenta" style="cursor: pointer; margin-left: 38%;"><i id="remove" class="glyphicon glyphicon-trash"></i></a></td></tr>');
							
							$('.student:last').hide();
							$('.student:last').fadeIn();

							$('#empty_list').css('display', 'none');
			
							var textToReplace = new RegExp(parts[i].trim() + '[\s]*[' + separator + ']?[\s]*');
						}

						$('#student_list').val($('#student_list').val().trim());

					} else {

						var firstnameStr = elems[0].trim();
						var lastnameStr = "";

						for (var j = 1; j < elems.length-1; j++) {
							lastnameStr += " " + elems[j].trim();
						}

						if (lastnameStr == '') {
							lastnameStr = '-';
						}

						if (!repThis) {
							$('table#st').css('display', '');
							$('table#st tbody').append('<tr class="student" id="' + (counter++) + '"><td id="number" style="text-align: center;">' + counter + '.</td><td id="fn">' + firstnameStr + '</td><td id="ln">' + lastnameStr + '</td><td id="em">' + emailToAppend + '</td><td><a title="Usuń studenta" style="cursor: pointer; margin-left: 38%;"><i id="remove" class="glyphicon glyphicon-trash" style="text-align: center;"></i></a></td></tr>');
							
							$('.student:last').hide();
							$('.student:last').fadeIn();

							$('#empty_list').css('display', 'none');

					 		var textToReplace = new RegExp(parts[i].trim() + '[\s]*[' + separator + ']?[\s]*');
							$('#student_list').val($('#student_list').val().trim().replace(textToReplace, ""));
						}
					}

				} else { errorCounter++;}
			}
		}
		}

		$("div#error_msg").remove();

		if(errorCounter > 0) {

			if (!($("div#error_msg").length > 0)) {
				$('div#student_input').append('<div id="error_msg" class="form-group has-error" style="margin-top: 10px;"><label class="control-label">Część danych została wprowadzona w niewłaściwym formacie</label></div>');
				$("div#error_msg").hide();
				$("div#error_msg").fadeIn();
			}
		} else {
			if ($("div#error_msg").length > 0) {
				$('div#error_msg').fadeOut();
			}
		}

		$("div#repet_msg").remove();

		if(rep) {

			if (!($("div#repet_msg").length > 0)) {
				$('div#student_input').append('<div id="repet_msg" class="form-group has-warning" style="margin-top: 10px;"><label class="control-label">Niektóre dane zostały już wprowadzone</label></div>');
				$("div#repet_msg").hide();
				$("div#repet_msg").fadeIn();
			}
		} else {
			if ($("div#repet_msg").length > 0) {
				$('div#repet_msg').fadeOut();
			}
		}

		$('#student_list').val($('#student_list').val().trim().replace('\n\n', '\n'));

	});


	$('button#confirm').click(function(e){

		var ld = Ladda.create(document.querySelector('button#confirm'));

		var unlocked_units = new Object();

		for(key in exam.day) {
			unlocked_units[key] = new Object();

			for(var i = 0; i < exam.day[key].length; i++) {
				unlocked_units[key][i] = new Array(exam.day[key][i].bHour, exam.day[key][i].eHour, true);
			}
		}

		emails = new Array();
		first_names = new Array();
		last_names = new Array();

		for (var z = 0; z < counter; z++) {

			if ($('#' + z).is(":visible") ) {
				emails.push($('#' + z).find('#em').html());
				first_names.push($('#' + z).find('#fn').html());
				last_names.push($('#' + z).find('#ln').html());
			}
		}

		$.ajax({

		type: "POST",
		url: "controler/CreateExamInBase.php",
		dataType: "JSON",
		data: {
			exam_name : $('input#exam_name').val().trim(),
			exam_duration : $('input#exam_duration').val(),
			students_emails : emails,
			firstnames : first_names,
			lastnames : last_names,
			unlocked_units : unlocked_units,
		},
		success: function (data) {

			if(data['status'] == 'error') {
				bootbox.alert('<div class="alert alert-success" style="margin-top: 4%; margin-bottom: 0%;">' + data['errorMsg'] + '.</strong></div>');
			} else {
				bootbox.alert('<div class="alert alert-success" style="margin-top: 4%; margin-bottom: 0%;"><strong>Pomyślnie dodano egzamin.</strong></div>', function() {
					window.location = 'ExamList.php';
				});
			}

			setInterval(function(){
				window.location = 'ExamList.php';
			}, 2000);
		},
		error: function (error) {
			bootbox.alert('<div class="alert alert-danger" style="margin-top: 4%; margin-bottom: 0%;"><strong>Wystąpił błąd przy dodawaniu egzaminu.</strong></div>');
		},
		complete: function() {
			ld.stop();
		}

		});
	});

	$('#addExamForm').submit(function () { 
		var validate = 0;
		var examDate = $('#exam-date').val();
		var today = new Date();		 
		var startHour = converToMinutes($('#start-hour').val());
		var endHour = converToMinutes($('#end-hour').val());
		
		if(exam.day[examDate] != undefined){
			for(term in exam.day[examDate]){				
				if(startHour >= converToMinutes(exam.day[examDate][term].bHour) && startHour < converToMinutes(exam.day[examDate][term].eHour)){
					validate = 5;
				}
				if(endHour > converToMinutes(exam.day[examDate][term].bHour) && endHour <= converToMinutes(exam.day[examDate][term].eHour)){
					validate = 5;
				}
				if(startHour < converToMinutes(exam.day[examDate][term].bHour) && endHour > converToMinutes(exam.day[examDate][term].eHour)){
					validate = 5;
				}
			}
		}
		if(converToMinutes($('#start-hour').val()) >= converToMinutes($('#end-hour').val())){			
			validate = 1;
		}
		if ( $("#duration").val() == '' || $("#exam-date").val() == '' || $("#start-hour").val() == '' || $("#end-hour").val() == ''){
			validate = 2;
		}
		if (Date.parse(examDate) < today){
			validate = 3;
		}
		if ($("#duration").val() < 5) {
			validate = 4;
		}

		switch(validate)
		{
		case 1:
  			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
							'<span style="padding:5px">Godzina rozpoczęcia powinna być wcześniej niż godzina zakończenia.</span>') ; 			
  			break;
		case 2:
  			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Należy wypełnić wszystkie pola.</span>') ;
  			break;
  		case 3:
  			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Podana data już minęła. Podaj inną date.</span>') ;
  			break;
  		case 4:
  			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Czas egzaminu powinien wynosić co najmniej 5 minut.</span>') ;
  			break;
  		case 5:
  			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Godziny egzaminu nakładają się na siebie! Podaj inne czasy.</span>') ;
  			break;
		default:
  			exam.addTerm( $("#exam-date").val() , $("#start-hour").val() , $("#end-hour").val()  , $("#duration").val() ) ;  
			calendarControl.examDays = exam.day ;
			calendarControl.printCalendar() ;			
			$("#error").html('');
			$('#myModal').modal('hide') ;						 
			$('#addExamForm')[0].reset();
		}  
		return false ; 
	} );	
	
	
	$('#exam_name').focusout ( function ( ) {  
		//alert("exam name is " + $(this).val() );
		exam.name =  $(this).val() ; 
		exam.duration = $('#exam_duration').val();  
	}); 
	
	$('#exam_duration').focusout ( function ( ) {  
		exam.duration = $(this).val() ;
	}); 
	
	$(document).on("click", "#removeDayButton", function() {  
		// alert( $(this).attr("name") ) ; 
		exam.delTerm($(this).attr("name"));
		calendarControl.examDays = exam.day ;
		calendarControl.printCalendar() ;
	});  
	
	$(document).on("click", "#removeRecordIcon", function() {
			var currentInput = $(this) ;
			var date =   jQuery.trim( currentInput.closest(".panel").find(".panel-heading").html()) ; 
			var dt = '#'+ date;
			var px = $(dt).scrollTop();
			
			$(this).closest("tr").fadeOut("slow" , function () { 
			//	var date =   jQuery.trim( currentInput.closest(".panel").find(".panel-heading").html()) ;
				var examHours = currentInput.closest("td").next().html().split("-") ;
				var startHour = jQuery.trim(examHours[0]) ; 
				exam.removeExamHoursForDay ( date , startHour ) ; 
				calendarControl.examDays = exam.day ;
				//alert ("printing calendar" ) ; 
				calendarControl.printCalendar() ;
				$(dt).scrollTop(px);
			}) ; 
	});
	
	$("#addExamDayGlyph").click( function ( ) { 
		$("#duration").val( $('#exam_duration').val() );
	});

	$('body').on( "click", 'i#remove', function(){

		var st_id = $(this).parent().parent().parent().first().attr('id');

		var isEmpty = false;

		if ($('tbody .student').length == 1) {
			isEmpty = true;
		}

		$('tr#' + st_id).hide(300, function(){ 
			$('tr#' + st_id).remove(); 
			counter--;

			$('td#number').each(function(index) {
				$(this).text((index+1) + '.');
			});
		});

		for(var i = emailsAdded.length - 1; i >= 0; i--) {
    		if(emailsAdded[i] === $('tr#' + st_id).find('#em').html()) {
       			emailsAdded.splice(i, 1);
    		}
		}

		if (isEmpty) {
			$('#empty_list').fadeIn();

			$('#st').css('display', 'none');
		}

	});

	$('#student_list').keyup(function() {

		if ($('#student_list').val().trim() == "") {
			$('button#add_students').attr("disabled", "disabled");
		} else {
			$('button#add_students').removeAttr("disabled");
		}
	});

	$('#student_list').change(function() {

		if ($('#student_list').val().trim() == "") {
			$('button#add_students').attr("disabled", "disabled");
		} else {
			$('button#add_students').removeAttr("disabled");
		}
	});

	$('a#changeChars').click(function() {

		if ($(this).text() == "Zmień") {

			$('span#char1').html('<input id="charToSet1" type="text" value="' + char1 + '" style="width: 16px; height: 21px; margin-right: 0px; padding-bottom: 2px; text-align: center;" maxlength="1"/>');
			$('span#char2').html('<input id="charToSet2" type="text" value="' + char2 + '" style="width: 16px; height: 21px; margin-right: 0px; padding-bottom: 2px; text-align: center;" maxlength="1"/>');
			$('span#separator').html('<input id="separatorToSet" type="text" value="' + separator + '" style="width: 16px; height: 21px; margin-right: 0px; padding-bottom: 2px; text-align: center;" maxlength="1"/>');
		
			$('a#changeChars').text('Zatwierdź');

			$('button#add_students').attr('disabled', 'disabled');

		} else {

			if ($('#separatorToSet').val().trim() == "") {
				$('#empty_separator_info').remove();

				if($('#empty_separator_info').length <= 0) {
					$('#format_label').append('<span id="empty_separator_info" class="pull-right" style="color: #b94a48">Podaj separator!</span>');
					$('#empty_separator_info').hide();
					$('#empty_separator_info').fadeIn();
				}
			} else {
				$('#empty_separator_info').fadeOut();

				char1 = $('#charToSet1').val();
				char2 = $('#charToSet2').val();
				separator = $('#separatorToSet').val();

				$('span#char1').html(char1);
				$('span#char2').html(char2);
				$('span#separator').html(separator);

				$('a#changeChars').text('Zmień');

				$('button#add_students').removeAttr("disabled");
			}
		}
	});

});
