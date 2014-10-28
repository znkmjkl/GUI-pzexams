
$( document ).ready(function() {
	
	$('#updateBtn').click(function () {
 		
 		examID = String(window.location).split("examID=")[1];
 		examName = $('#exam_name').val();
 		examDuration = $('#exam_duration').val();
 		
 		if(examName.length < 5 || examName.length > 60){
 			$("#name-error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Nazwa powinna mieć od 5 do 60 znaków.</span>') ;
 			
 		} else if ( examDuration < 5 || examDuration > 60 ) {
 			$("#duration-error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Czas trwania egzaminu może mieć wartość od 5 do 60 min.</span>') ;
 		} else {
 			var uBtn = this;
	    	uBtn.disabled = true;
	    	$("#duration-error").html('');
	    	$("#name-error").html('');
 			$.ajax({
	 			type: "POST",
 				url: "lib/Ajax/AjaxExamBasicUpdate.php",
 				dataType: "JSON",
 				data: {
	 				examID : examID,
 					examName : examName,
 					examDuration : examDuration,
 				},
 				success: function (data) {
 					if(data['status'] == 'failed'){
 						bootbox.alert('<div class="alert alert-danger"><strong>' + data['errorMsg'] + '</strong></div>');
 					}				
	 				if(data["changes"] == "1"){				
 						bootbox.alert('<div class="alert alert-success"><strong>Pomyślnie zaaktualizowano dane egzaminu.</strong></div>');
 					}
 					
 					setTimeout(function() {
                			uBtn.disabled = false;
            		}, 2000);			
 				},
 				error: function (error) {
	 				alert('Wystapil błąd');
 				},
 				complete: function() {
	 			
 				}
 			});		

 		}
		return false;
 	});
	
	$('#addExamForm').submit(function () { 
		var validate = 0;
		var examDate = $('#exam-date').val();
		var startHour = converToMinutes($('#start-hour').val());
		var endHour = converToMinutes($('#end-hour').val());
		var today = new Date();		 
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
		if(editExamCalendarManager.exam.day[examDate] != undefined){
			for(var term in editExamCalendarManager.exam.day[examDate]){
				if(startHour >= converToMinutes(editExamCalendarManager.exam.day[examDate][term].bHour) && startHour < converToMinutes(editExamCalendarManager.exam.day[examDate][term].eHour)){
					validate = 5;
				}
				if(endHour > converToMinutes(editExamCalendarManager.exam.day[examDate][term].bHour) && endHour <= converToMinutes(editExamCalendarManager.exam.day[examDate][term].eHour)){
					validate = 5;
				}
				if(startHour < converToMinutes(editExamCalendarManager.exam.day[examDate][term].bHour) && endHour > converToMinutes(editExamCalendarManager.exam.day[examDate][term].eHour)){
					validate = 5;
				}
			}
		}
		
		if(validate == 1){
			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Godzina rozpoczęcia powinna być wcześniej niż godzina zakończenia.</span>') ; 			
		} else if (validate == 2) {
			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Należy wypełnić wszystkie pola.</span>') ;			
		} else if (validate == 3) {
			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Podana data już minęła. Podaj inną date.</span>') ;			
		} else if (validate == 4) {
			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Czas egzaminu powinien wynosić co najmniej 5 minut.</span>') ;	
		} else if (validate == 5) {
  			$("#error").html('<span style="background-color:#F13333;" class="badge pull-left ">!</span>' +
											'<span style="padding:5px">Godziny egzaminu nakładają się na siebie! Podaj inne czasy.</span>') ;
		} else {
			editExamCalendarManager.insertExamUnits( $("#exam-date").val() , $("#start-hour").val() , $("#end-hour").val()  , $("#duration").val()) ;  	
			$("#error").html('');
			$('#myModal').modal('hide') ;						 
			$('#addExamForm')[0].reset();
		}
		// alert  ( exam.name + " --- " + exam.duration  ) ; 
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
		var date =  $(this).attr("name") ; 
		if ( editExamCalendarManager.checkIfStudentsEnroledOnDay(date) ) {
			bootbox.dialog({
				message: "Na wybrany do usunięcia dzień są już zapisani studenci.",
				title: "Uwaga",
				buttons: {
					cancel: {
						label: "Anuluj",
						className: "btn",
						callback: function() {
							
						}
					},
					remove: {
						label: "Usuń",
						className: "btn-danger",
						callback: function() {
							editExamCalendarManager.removeAllUnitsForDay(date) ;
						}
					}
				}
			});
		} else { 
			editExamCalendarManager.removeAllUnitsForDay($(this).attr("name")) ;
		} 
	});  
	
	$(document).on("click", "#removeRecordIcon", function() {
		var currentInput = $(this) ;
		var date =   jQuery.trim( currentInput.closest(".panel").find(".panel-heading").html()) ;
		var examHours = currentInput.closest("td").next().html().split("-") ;
		var startHour = jQuery.trim(examHours[0]) ;
		var dt = "#" + date ;
		var px = $(dt).scrollTop() ;
		var that = this ; 
		if (editExamCalendarManager.checkIfStudentEnroledOnExamUnit(date , startHour)) {
			bootbox.dialog({
				message: "Na wybraną do usunięcia godzinę jest zapisany student.",
				title: "Uwaga",
				buttons: {
					cancel: {
						label: "Anuluj",
						className: "btn",
						callback: function() {
							
						}
					},
					remove: {
						label: "Usuń",
						className: "btn-danger",
						callback: function() {
							$(that).closest("tr").fadeOut("slow", function() {
								editExamCalendarManager.removeSingleExamUnit( date, startHour ) ;
								$(dt).scrollTop(px);
							}) ; 								
						}
					}
				}
			});
		} else {
			$(this).closest("tr").fadeOut("slow", function (){
				editExamCalendarManager.removeSingleExamUnit( date, startHour ) ;
				$(dt).scrollTop(px) ;	
			});	
		}
	});
	
	$("#addExamDayGlyph").click( function ( ) { 
		$("#duration").val( $('#exam_duration').val() );
	});
}) ; 
