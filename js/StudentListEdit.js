var char1 = "<";
var char2 = ">";
var separator = ",";
var emailsAdded = new Array();

var ajax_requests = 0;

var ld = null;

$(document).ready(function() {
	ld = Ladda.create(document.querySelector('#add_students'));

	if($('tbody .student').length <= 0) {
		$('#examStudentsListPDFGlyph').attr('disabled', 'disabled');
		$('#sendEmails').attr('disabled', 'disabled');
	}

	$('tbody .student').each(function(index, element) {
		emailsAdded.push($(element).find('#emails').text().trim());
	});

	$('#student_list_modal').on('hidden.bs.modal', function () {
		$('#student_list').val('');
	});

	$('#student_list_modal').on('shown', function () {
		$('#student_list').focus();
	});

	$('button#add_students').attr("disabled", "disabled");

	$('body').on( 'click', 'a#send', function(){
		var studentID = $(this).parent().parent().first().attr('id');
		var email = $(this).parent().parent().find("#emails").html();

		$('tr#'+studentID).find('#send').bind('click', false);
		$('tr#'+studentID).find('#remove').bind('click', false);
		
		$('#sendEmails').attr('disabled', 'disabled');
		$('#display_modal').attr('disabled', 'disabled');
		$('#examStudentsListPDFGlyph').attr('disabled', 'disabled');

		if ($('tr#' + studentID).find('#comment').html() == '') {
			$('tr#' + studentID).find('#comment').append('<img id="send_animation' + studentID +'" style="height: 50%; width: auto; margin-left: 18%;" src="img/sending.gif"/>');
			$('#send_animation'+studentID).hide();
			$('#send_animation'+studentID).fadeIn();
		}

		$.ajax({
			type: "POST",
			url: "lib/Ajax/AjaxSendMailsToStudents.php",
			dataType: "JSON",
			data: {
				examID : String(window.location).split("examID=")[1],
				studentID : studentID,				
			},
			success: function (data) {
				if(data['status'] == 'failed'){
					bootbox.alert('<div class="alert alert-danger" style="margin-top: 4%; margin-bottom: 0%;"><strong>'+ data['errorMsg'] +'</strong></div>');		
				} else {
					//bootbox.alert('<div class="alert alert-success" style="margin-top: 4%; margin-bottom: 0%;">Mail został wysłany na adres <b>'+ email +'</b>!</div>');
					$('tr#' + studentID).find('#comment').append('<span id="success_text' + studentID + '" style="font-size: 14px; color: #5cb85c; font-weight: bold;">Wysłano</span>');
					$('span#success_text' + studentID).hide();
					$('span#success_text' + studentID).fadeIn( "slow", function() {
    					setTimeout(function(){$('span#success_text' + studentID).hide(300, function() { $('span#success_text' + studentID).remove()}); }, 5000);
  					});
					$('tr#' + studentID).find('#is_sent').html("<b style=\"color: #156815;\">Tak</b>");
				}
			},
			error: function (error) {
				bootbox.alert('<div class="alert alert-danger" style="margin-top: 4%; margin-bottom: 0%;"><strong>Wystąpił błąd przy wysyłaniu maila!</strong></div>');		
			},
			complete: function() {
				$('#send_animation'+studentID).hide(0, function() {
					$('#send_animation'+studentID).remove();
				});

				$('tr#'+studentID).find('#send').unbind('click', false);
				$('tr#'+studentID).find('#remove').unbind('click', false);

				$('#sendEmails').removeAttr('disabled');
				$('#display_modal').removeAttr('disabled');
				$('#examStudentsListPDFGlyph').removeAttr('disabled');
			}
		});
	});

	$('button#sendEmails').click(function() {
		$(this).after('<span id="sending_info" style="margin-left: 10px; font-weight: bold;">Trwa wysyłanie, proszę czekać...</span>');
		$('#sending_info').hide();
		$('#sending_info').fadeIn();

		$('a#remove').each(function(index, element) {
			$(element).bind('click', false);
		});

		$('a#send').each(function(index, element) {
			$(element).bind('click', false);
		});

		$('#display_modal').attr('disabled', true);
		$('#examStudentsListPDFGlyph').attr('disabled', true);

		$(this).attr('disabled', true);
		$(this).html('<img id="send_animation" style="height: 5%; width: auto;" src="img/sending-white.gif"/>');

		$.ajax({
			type: "POST",
			url: "lib/Ajax/AjaxSendMailsToStudents.php",
			dataType: "JSON",
			data: {
				examID : String(window.location).split("examID=")[1],
				mails : 1,				
			},
			success: function (data) {
				if (data['status'] == 'failed') {
					bootbox.alert('<div class="alert alert-danger" style="margin-top: 4%; margin-bottom: 0%;"><strong>'+ data['errorMsg'] +'</strong></div>');		
				} else {
					bootbox.alert('<div class="alert alert-success" style="margin-top: 4%; margin-bottom: 0%;"><strong>Maile zostały wysłane do studentów z listy!</strong></div>');

					$('td#is_sent').each(function(index, element) {
						$(element).html('Tak');
					});
				}				
			},
			error: function (error) {
				alert('Wystapil blad przy wysyłaniu mailów!');
			},
			complete: function() {
				$('button#sendEmails').html('<i class="glyphicon glyphicon-send" style="margin-right: 5px;"></i>Wyślij email do wszystkich');
				$('button#sendEmails').removeAttr('disabled');

				$('a#remove').each(function(index, element) {
					$(element).unbind('click', false);
				});

				$('a#send').each(function(index, element) {
					$(element).unbind('click', false);
				});

				$('#display_modal').removeAttr('disabled');
				$('#examStudentsListPDFGlyph').removeAttr('disabled');

				$('#sending_info').hide(300, function(){ 
						$('#sending_info').remove(); 
				});
			}
		});
	});

	$('button#add_students').click( function(){
		ld.start();

		var errorCounter = 0;
		var rep = false;

		var email_p = new RegExp("^[\\" + char1 + "]?[\\w-_\.+]*[\\w-_\.]\@([\\w]+\\.)+[\\w]+[\\w][\\" + char2 +"]?$");

		var parts = $('#student_list').val().trim().split(separator);

		if (parts != null) {

			for(var i = 0; i < parts.length; i++) {

				var repetCounter = 0;

				var elems = parts[i].trim().split(" ");

				if (parts[i].trim() != "" && parts[i] != null) {

				 if (elems[elems.length-1].trim().match(email_p) != null) {

					var repThis = false;

					var emailToAppend = elems[elems.length-1].trim().replace(char1, "").replace(char2, "");
					emailsAdded.push(emailToAppend);

					for (var g = 0; g < emailsAdded.length-1; g++) {
						if (emailToAppend.trim() == emailsAdded[g]) {
							rep = true;
							repThis = true;
						}
					}

					if (elems.length == 1) {
							addStudent("", "", emailToAppend); ajax_requests++;
												
							if (!repThis) {				
								var textToReplace = new RegExp(parts[i].trim() + '[\s]*[' + separator + ']?[\s]*');
								$('#student_list').val($('#student_list').val().trim().replace(textToReplace, "")); 
							}

					} else {
						var firstnameStr = elems[0].trim();
						var lastnameStr = "";

						for (var j = 1; j < elems.length-1; j++) {
							lastnameStr += " " + elems[j].trim();
						}

						addStudent(firstnameStr, lastnameStr, emailToAppend); ajax_requests++;
												
						if (!repThis) {
							var textToReplace = new RegExp(parts[i].trim() + '[\s]*[' + separator + ']?[\s]*');
							$('#student_list').val($('#student_list').val().trim().replace(textToReplace, ""));
						}
					}

				} else { 
					errorCounter++;
				}
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

		if (ajax_requests == 0) {
			ld.stop();
		}
});


	$('body').on( "click", 'a#remove', function(){
		var st_id = $(this).parent().parent().first().attr('id');

		$('tr#'+st_id).find('#remove').bind('click', false);

		$.ajax({

			type: "POST",
			url: "lib/Ajax/AjaxStudentDeletingRequest.php",
			dataType: "JSON",
			data: {
				student_id : st_id,
				exam_id : String(window.location).split("examID=")[1]
			},
			success: function (data) {

				if (data)
				{
					var isEmpty = false;

					if ($('tbody .student').length == 1) {
						isEmpty = true;
					}

					$('tr#' + st_id).hide(300, function(){ 
						$('tr#' + st_id).remove(); 

						$('td#number').each(function(index) {
							$(this).text((index+1) + '.');
						});

					});

					for(var i = emailsAdded.length - 1; i >= 0; i--) {
    					if(emailsAdded[i] === $('tr#' + st_id).find('#emails').html()) {
       						emailsAdded.splice(i, 1);
    					}
					}

					if (isEmpty) {
						$('#empty_list').fadeIn();
						$('#examStudentsListPDFGlyph').attr('disabled', 'disabled');
						$('#sendEmails').attr('disabled', 'disabled');
						$('#students').css('display', 'none');
					}
				}
			},
			error: function (error) {
				alert('Wystapił błąd przy usuwaniu studenta.');
			},
			complete: function() {
				
			}

			});
	});


	$('a#changeChars').click(function() {
		if ($(this).text() == "Zmień") {
			$('span#char1').html('<input id="charToSet1" type="text" value="' + char1 + '" style="width: 16px; height: 21px; margin-right: 0px; padding-bottom: 2px; text-align: center;" maxlength="1"/>');
			$('span#char2').html('<input id="charToSet2" type="text" value="' + char2 + '" style="width: 16px; height: 21px; margin-right: 0px; padding-bottom: 2px; text-align: center;" maxlength="1"/>');
			$('span#separator').html('<input id="separatorToSet" type="text" value="' + separator + '" style="width: 16px; height: 21px; padding-bottom: 2px; margin-right: 0px; text-align: center;" maxlength="1"/>');

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

});


function addStudent(fn, ln, em) {
		$.ajax({
			type: "POST",
			url: "lib/Ajax/AjaxStudentAddingRequest.php",
			dataType: "JSON",
			data: {
				exam_id : String(window.location).split("examID=")[1],
				firstname : fn,
				lastname : ln,
				email : em
			},
			success: function (data) {

				if (data != null) {

					var nr = $('#students').find('tr').size();
					var first = "";
					var last = "";

					if (data[1] == "") {
						first = "-";
					} else {
						first = data[1];
					}

					if (data[2] == "") {
						last = "-";
					} else {
						last = data[2];
					}

					$('table#students tbody').append('<tr class="student" id="' + data[0] + '"><td id="number" style="text-align: center;">' + nr +'.</td><td id="firstname">' + 
					first + '</td><td id="lastname">' + 
					last + '</td><td id="emails">' + 
					data[3] + '</td><td id="is_sent" style="text-align: center;"><b style="color: #801313;">Nie</b></td><td style="text-align:center; vertical-align:middle;"><a id="remove"><i title="Usuń studenta" class="glyphicon glyphicon-trash" style="margin-right: 12px; cursor: pointer;"></i></a><a id="send" title="Wyślij wiadomość z kodem dostępu do studenta" style="cursor: pointer;"><i class="glyphicon glyphicon-envelope"></i></a></td><td id="comment" style="padding-left: 10x; padding-right: 0px; padding-top: 6px;"></td></tr>');

					$('tr#'+data[0]).hide();
					$('tr#'+data[0]).fadeIn(400);

					$('#empty_list').fadeOut();
					$('#examStudentsListPDFGlyph').removeAttr('disabled');
					$('#sendEmails').removeAttr('disabled');

					$('#students').css('display', '');
					
					ajax_requests--;

					if (ajax_requests == 0) { 
						ld.stop(); 
					}
				}
			},
			error: function (error) {
				alert('Wystapil blad przy dodawaniu studenta/ów.');
			},
			complete: function() {
				ld.stop();
			}
		});
}
