jQuery(document).ready(function($) {
	bootbox.setDefaults({ locale: "pl" });
	
	$("a[id^=row-delete-id-]").click(function() {
		var id          = $(this).attr("id");
		var studentID   = id.slice(id.lastIndexOf("-") + 1, id.length);
		var studentName = $("#row-email-id-" + studentID).html();
		var rowID       = "#row-id-" + studentID;
		
		bootbox.confirm("Czy na pewno chcesz usunąć następującego Studenta <b>\"" + studentName + "\"</b>?", function(result) {
			if (result) {
				$.ajax({
					type: "POST",
					url:  "lib/Ajax/AjaxStudentDeleteRequest.php",
					data: {
						ID : studentID
					},
					success: function(data, status) {
						status = data.status.trim();
						
						if (status === "success") {
							$(rowID).remove();
							
							var lastLp = 0;
							$("td[id^=row-lp-]").each(function() {
								var id = $(this).attr("id");
								var lp = id.slice(id.lastIndexOf("-") + 1, id.length);
								
								if (lastLp + 1 != lp) {
									$("#" + id).html((lastLp + 1) + ".");
								}
								lastLp = lastLp + 1;
							});
						}
						else if (status === "failed") {
							msg = data.errorMsg.trim();
							
							if (msg != null) {
								alert(msg);
							}
						}
					},
					error: function(xhr, textStatus, errorThrown) {
						alert("Nie udało się uruchomić zapytania Ajax.");
					}
				});
			}
		});
	});
	
	$("a[id^=delete-students]").click(function() {
		bootbox.confirm("Czy na pewno chcesz usunąć nieaktywnych studentów</b>?", function(result) {
			if (result) {
				window.location.href = "controler/DeleateExpiredStudents.php";
			}
		});
	});

});
