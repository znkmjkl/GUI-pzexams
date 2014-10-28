jQuery(document).ready(function($) {
	bootbox.setDefaults({ locale: "pl" });
	
	$("a[id^=row-delete-id-]").click(function() {
		var id       = $(this).attr("id");
		var examID   = id.slice(id.lastIndexOf("-") + 1, id.length);
		var examName = $("#row-name-id-" + examID).html();
		var rowID    = "#row-id-" + examID;
		
		bootbox.confirm("Czy na pewno chcesz usunąć następujący egzamin <b>\"" + examName + "\"</b>?", function(result) {
			if (result) {
				$.ajax({
					type: "POST",
					url:  "lib/Ajax/AjaxExamDeleteRequest.php",
					data: {
						ID : examID
					},
					success: function(data, status) {
						status = data.status.trim();
						
						if (status === "success") {

							var isEmpty = false;

							if ($('tbody tr').length <= 1) {
									isEmpty = true;
							}
							
							var lastLp = 0;
							$("td[id^=row-lp-]").each(function() {
								var id = $(this).attr("id");
								var lp = id.slice(id.lastIndexOf("-") + 1, id.length);
								
								if (lastLp + 1 != lp) {
									$("#" + id).html((lastLp + 1) + ".");
								}
								lastLp = lastLp + 1;
							});

							if(isEmpty) {
								$('#current_exams').hide();

								$('#current_exams').before('<div id="no_exam" class="alert alert-info"><b>Nie dodałeś jeszcze żadnych egzaminów!</b> Zobacz jakie to proste i <u><b><a href="AddExam.php">utwórz</a></b></u> swój pierwszy egzamin.</div>');
								$('#no_exam').hide();
								$('#no_exam').fadeIn();

								$('#info_if_not_empty').hide();
							}

							$(rowID).hide(300, function(){ 
								$(rowID).remove(); 
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
	
	$("button[id^=row-activate-button-id-]").click(function() {
		var status = $(this).attr("value");
		var id = $(this).attr("id");
		var examID = id.slice(id.lastIndexOf("-") + 1, id.length);		
		var sBtn = this;
    	sBtn.disabled = true;

		$.ajax({
			type: "POST",
			url: "lib/Ajax/AjaxExamActivationRequest.php",
			dataType: "JSON",
			data: {
				examID : examID,
			},
			success: function (data) {
				if(data['status'] == 'failed'){
					alert(data['errorMsg']);
				} else {
					if(status == 0){
						/*if(data['emailsPost'] == '1'){
							alert("Maile z informacją o egzaminie zostały wysłane do studentów.")
						}*/
						bootbox.alert('<div class="alert alert-success" style="margin-top: 4%; margin-bottom: 0%;"><strong>Pomyślnie zmieniono status na aktywny.</strong></div>');
						$("#" + id).attr("class", "btn btn-danger dropdown-toggle btn-sm");
						$("#" + id).html("<b>Dezaktywuj</b>");
						$("#row-activated-id-" + examID).html("<b style=\"color: #156815;\">Tak</b>");
						$("#" + id).attr("value", 1);	
					} else {
						bootbox.alert('<div class="alert alert-success" style="margin-top: 4%; margin-bottom: 0%;"><strong>Pomyślnie zmieniono status na nieaktywny.</strong></div>');
						$("#" + id).attr("class", "btn btn-success dropdown-toggle btn-sm");
						$("#" + id).html("<b>Aktywuj</b>");
						$("#row-activated-id-" + examID).html("<b style=\"color: #801313;\">Nie</b>");
						$("#" + id).attr("value", 0);	
					}
					 setTimeout(function() {
                		sBtn.disabled = false;
            		}, 2000);
				}
			},
			error: function (error) {				
				bootbox.alert('Wystąpił blad przy zmianie statusu egzaminu.');
			},
			complete: function() {
				//window.location = 'ExamList.php';
			}
		});
	});
	
	$("a[id^=row-edit-id-]").click(function(){
		var id = $(this).attr("id");	
		var examID = id.slice(id.lastIndexOf("-") + 1, id.length);		
		var html = '<br/><div class="alert alert-danger"><strong>Aby edytować ten egzamin musisz najpierw go deaktywować!</strong></div>';
		$.ajax({
			type: "POST",
			url: "lib/Ajax/AjaxExamCheckActivated.php",
			dataType: "JSON",
			data: {
				examID : examID,
			},
			success: function (data) {		
				if(data['activated'] == '1'){
					bootbox.alert(html);
				} else {
					window.location = 'ExamEdit.php?examID=' + examID;
				}
				
			},
			error: function (error) {				
				bootbox.alert('Wystąpił błąd.');
			},
			complete: function() {
				//window.location = '';
			}
		});		

		return false;		
	});
	
});
