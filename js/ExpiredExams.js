jQuery(document).ready(function($) {
	bootbox.setDefaults({ locale: "pl" });
	
	$("a[id^=delete-exams]").click(function() {
		bootbox.confirm("Czy na pewno chcesz usunąć egzaminy po terminach</b>?", function(result) {
			if (result) {
				window.location.href = "controler/DeleateExpiredExams.php";
			}
		});
	});
	
});
