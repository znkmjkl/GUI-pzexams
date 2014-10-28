jQuery(document).ready(function($) {
	bootbox.setDefaults({ locale: "pl" });
	
	$("a[id^=row-delete-id-]").click(function() {
		var id       = $(this).attr("id");
		var userID   = id.slice(id.lastIndexOf("-") + 1, id.length);
		var userName = $("#row-email-id-" + userID).html();
		var rowID    = "#row-id-" + userID;
		
		bootbox.confirm("Czy na pewno chcesz usunąć następującego Użytkownika <b>\"" + userName + "\"</b>?", function(result) {
			if (result) {
				$.ajax({
					type: "POST",
					url:  "lib/Ajax/AjaxUserDeleteRequest.php",
					data: {
						ID : userID
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
	
});
