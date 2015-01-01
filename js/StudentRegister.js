function validateRadio(obj) {
	var checked = null;
	var inputs = document.getElementsByName('optionsRadios');
	var error = document.getElementById("error-message");
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].checked) {
			checked = inputs[i];
			break;
		}
	}
	if (checked === null) {
		error.innerHTML = '<span style="background-color:#F13333;" class="badge pull-left ">!</span><span style="padding:5px"> Musisz zaznaczyć termin na który chcesz się zapisać.</span>';
		return false;
	}else{
		error.innerHTML = "";
		return;
	}
}

jQuery(document).ready(function ($) {

	function showEdit() {
		$("div").off("click", "a#studentEditGlyph", showEdit);
		$("#innerEStudentID").val($('#studentID').val());
		$("#innerEStudentCode").val($('#studentCode').val());

		var innerEStudentID = $('#studentID').val();

		$.ajax({
			type: "POST",
			url: 'controler/StudentSignInOut.php',
			data: { action: 'edit', student: innerEStudentID },
			dataType: "html",
			cache: false,
			success: function (html) {
				$('#studentEditBody').html(html);
				$("div").on("click", "a#studentEditGlyph", showEdit);
			}
		});
	}

	function loadSignOut() {
		$("div").off("click", "a#signOutGlyph", loadSignOut);
		$("#innerStudentID").val($('#studentID').val());
		$("#innerStudentCode").val($('#studentCode').val());
		$("#innerExamID").val($(this).attr("value"));

		var innerStudentID = $('#studentID').val();
		var innerExamID = $(this).attr("value");

		$.ajax({
			type: "POST",
			url: 'controler/StudentSignInOut.php',
			data: { action: 'stepOut', exam: innerExamID, student: innerStudentID },
			dataType: "html",
			cache: false,
			success: function (html) {
				$('#signOutBody').html(html);
				$("div").on("click", "a#signOutGlyph", loadSignOut);
			}
		});
	}

	function loadSignIn() {
		$("div").off("click", "a#signInGlyph", loadSignIn);
		$("#innerIStudentID").val($('#studentID').val());
		$("#innerIStudentCode").val($('#studentCode').val());
		$("#innerIExamID").val($(this).attr("value"));
		$("#innerExamName").val($(this).attr("examname"));
		document.getElementById('innerExamName').innerHTML = $(this).attr("examname");
		var innerIStudentID = $('#studentID').val();
		var innerIStudentCode = $('#studentCode').val();
		var innerIExamID = $(this).attr("value");

		$.ajax({
			type: "POST",
			url: 'controler/StudentSignInOut.php',
			data: { action: 'step1', exam: innerIExamID },
			dataType: "html",
			cache: false,
			success: function (html) {
				$('#signInBody').html(html);
			}
		});

		$.ajax({
			type: "POST",
			url: 'controler/StudentSignInOut.php',
			data: { action: 'stepF1' },
			dataType: "html",
			cache: false,
			success: function (html) {
				$('#signInFooter').html(html);
				$("div").on("click", "a#signInGlyph", loadSignIn);
			}
		});

	}

	function chosenExam() {
		$("div").off("click", "a#date", chosenExam);
		var examDate = $(this).attr("examDate");
		var innerIExamID = $("#innerIExamID").val();

		$.ajax({
			type: "POST",
			url: 'controler/StudentSignInOut.php',
			data: { action: 'step2', exam: innerIExamID, examDate: examDate },
			dataType: "html",
			cache: false,
			success: function (html) {
				$('#signInBody').html(html);
			}
		});

		$.ajax({
			type: "POST",
			url: 'controler/StudentSignInOut.php',
			data: { action: 'stepF2' },
			dataType: "html",
			cache: false,
			success: function (html) {
				$('#signInFooter').html(html);
				$("div").on("click", "a#date", chosenExam);
			}
		});

	}

	function getBack() {
		$("div").off("click", "a#back", getBack);
		var innerIExamID = $("#innerIExamID").val();

		$.ajax({
			type: "POST",
			url: 'controler/StudentSignInOut.php',
			data: { action: 'step1', exam: innerIExamID },
			dataType: "html",
			cache: false,
			success: function (html) {
				$('#signInBody').html(html);
			}
		});

		$.ajax({
			type: "POST",
			url: 'controler/StudentSignInOut.php',
			data: { action: 'stepF1' },
			dataType: "html",
			cache: false,
			success: function (html) {
				$('#signInFooter').html(html);
				$("div").on("click", "a#back", getBack);
			}
		});

	}

	$("div").on("click", "a#studentEditGlyph", showEdit);

	$("div").on("click", "a#signOutGlyph", loadSignOut);

	$("div").on("click", "a#signInGlyph", loadSignIn);

	$("div").on("click", "a#date", chosenExam);

	$("div").on("click", "a#back", getBack);

	$(document).on('click', 'examDayButton', loadExamUnitList);

	$('#examExchange').click(function() {
		$('#examUnitTable').hide();
		$('#examDayButton').show();
	});


(function($){
	$.fn.styleddropdown = function(){
		return this.each(function(){
			var obj = $(this);
			obj.find('.popupLink').click(function() {

			if($(this).closest('tr').hasClass('me')) {
				obj.find('.list').fadeIn(200);
			}
			
			$(document).keyup(function(event) {
				if(event.keyCode == 27) {
					obj.find('.list').fadeOut(200);
				}
			});
			
			obj.find('.list').hover(function(){ },
				function(){
					$(this).fadeOut(200);
				});
			});
			
			obj.find('.list li').click(function() {
			obj.find('.popupLink')
				.val($(this).html())
				.css({
					'background':'#fff',
					'color':'#333'
				});
			obj.find('.list').fadeOut(200);
			});
		});
	};
})(jQuery);


$(document).on('click', '.list li', function() {

	var hisClass = $(this).attr('class');
	var hisHtml = $('tbody tr.' + hisClass + ' td.studentName').html();

	var myHtml = $(this).closest('tr').find('.studentName').html();
	var myOferts = $(this).closest('tr').find('.oferts').html();
	var myClass = $(this).closest('tr').attr('class').split(' ')[0];

	$('tr.' + myClass + ' .studentName').html(hisHtml);
	$('tr.' + myClass + ' .oferts .ofertNr').removeClass('popupLink');
	$('tr.' + myClass + ' .oferts .ofertNr').html(Number($('tr.' + myClass + ' .oferts .ofertNr').html().charAt(0)) - 1);
	$('tr.' + myClass + ' .oferts .divPop').removeClass('exchangePopup');
	$('tbody tr.' + hisClass + ' .studentName').html(myHtml);
	$('tbody tr.' + hisClass + ' .oferts .ofertNr').addClass('popupLink');
	$('tbody tr.' + hisClass + ' .oferts .divPop').addClass('exchangePopup');
	$('tbody tr.' + hisClass).addClass('me');
	$('tr.' + myClass).removeClass('me');

	$('li.' + hisClass).remove();

	$('tr.' + hisClass).attr('style', 'font-weight: bold;');
	$('tr.' + myClass).attr('style', '');

	$('.list').fadeOut(200);

	$(function(){
		$('.exchangePopup').styleddropdown();
	});

});

	$(document).on('click', '.oferts button.btn-success', function() {
		var ofertNr = $(this).parent().find('.ofertNr');

		if(!$(this).hasClass('added')) {
			$(this).addClass('added');
			ofertNr.html(Number(ofertNr.html()) + 1);
			$(this).toggleClass('btn-success btn-danger');
			$(this).toggleClass('glyphicon-remove glyphicon-plus');
			$(this).attr('title', 'Cofnij ofertę wymiany');
		}
	});

	$(document).on('click', '.oferts button.btn-danger', function() {
		var ofertNr = $(this).parent().find('.ofertNr');

		ofertNr.html(Number(ofertNr.html()) - 1);
		$(this).removeClass('added');
		$(this).toggleClass('btn-success btn-danger');
		$(this).toggleClass('glyphicon-remove glyphicon-plus');
		$(this).attr('title', 'Zgłoś ofertę wymiany');
	});

	$(document).on('mouseenter', '.oferts', function() {

		var isAdded = $(this).find('button').hasClass('added');

		if(!isAdded) {
			if(!$(this).closest('tr').hasClass('me')) {
				$(this).find('button.btn-success').fadeIn(100);
			} else {
				if(!($('#showOferts').length > 0)) {
					if(!($('#showOferts').length > 0) && Number($(this).find('.ofertNr').html()) != 0) {
						$('.popupLink').append('<span id="showOferts"> - pokaż oferty</span>');
					}
				} else {
					$('#showOferts').show();
				}
			}
		}

	});

	$(document).on('mouseleave', '.oferts', function() {
		$(this).find('button.btn-success').fadeOut(100);
		if($(this).closest('tr').hasClass('me')) {
			$('#showOferts').hide();
		}
	});

$(function(){
	$('.exchangePopup').styleddropdown();
});

});

function loadExamUnitList() {
	$('#examDayButton').hide();
	$('#examUnitTable').show();
	$('.oferts button.btn-success').hide();
}




