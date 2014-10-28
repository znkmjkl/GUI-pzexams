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
	if (checked == null) {
		error.innerHTML = '<span style="background-color:#F13333;" class="badge pull-left ">!</span><span style="padding:5px"> Musisz zaznaczyć termin na który chcesz się zapisać.</span>'; 
		return false;
	}else{
		error.innerHTML = "";
		return;
	}
}

jQuery(document).ready(function ($) {

	function showEdit() {
		$("div").off("click", "a#studentEditGlyph", showEdit)
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

});