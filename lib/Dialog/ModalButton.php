	<button class="btn btn-success btn-lg" data-toggle="modal" id="addExamDayGlyph" data-target="#myModal" title="Dodaj termin">
  		<i class="glyphicon glyphicon-plus" style="font-size:30px; font-weight:bold;"></i>
	</button>
	
	<div class="modal fade modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-sm">
    		<div class="modal-content" style="background-color:#D5D4D9;;">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        			<h3 class="modal-title" id="myModalLabel"><b>Dodawanie terminu</b></h3>
      			</div>
      			<form name="modalForm" class="form-signin form-horizontal" id="addExamForm" data-toggle="validator" role="form" style="margin:10px; margin-right:10px;margin-left:10px" method="post" action="">
      				<div class="modal-body">
      					<div class="form-group" id="duration_group">
							<label for="duration" class="col-sm-5 control-label">Czas egzaminu</label>
							<div class="col-sm-3">
								<input name="duration" type="number" class="form-control" id="duration" placeholder="" maxlength="2" value="">
							</div>
							<label class="col-sm-1 control-label"> [min] </label>
						</div>
      					<div class="form-group">
                			<label for="dtp_input2" class="col-sm-5 control-label">Dzień</label>
                			<div class="input-group date form_date col-md-6" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    			<input name="date" class="form-control"  id="exam-date" size="16" type="text" value="" readonly>
                    			<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar glyphicon-nonescaped"></span></span>
                			</div>
							<input type="hidden" id="dtp_input2" value="" /><br/>
            			</div>
						
						<div class="form-group">
                			<label for="dtp_input3" class="col-sm-5 control-label">Godzina rozpoczęcia</label>
                			<div class="input-group date form_time col-md-6" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                    			<input name="bHour" class="form-control" id="start-hour" size="16" type="text" value="" readonly>
                    			<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                			</div>
							<input type="hidden" id="dtp_input3" value="" /><br/>
            			</div>
            			<div class="form-group">
	                		<label for="dtp_input3" class="col-sm-5 control-label">Godzina zakończenia</label>
    	            		<div class="input-group date form_time col-md-6" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
        	            		<input name="eHour" class="form-control" id="end-hour" size="16" type="text" value="" readonly>
            	        		<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                			</div>
							<input type="hidden" id="dtp_input3" value="" /><br/>
    	        		</div>
            	   		<span class="help-block" id="error" style="height:10px;"></span>          					
          			</div>   
      					<div class="modal-footer">
        					<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
        					<button type="submit" class="btn btn-success"  id="add-exam-date">Dodaj termin</button>
      					</div>
      			</form>
    		</div>
  		</div>
	</div>	
<script type="text/javascript" defer>
    
	$('.form_date').datetimepicker({
        language:  'pl',
        format: 'yyyy-mm-dd',
        weekStart: 1,        
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0,
		todayBtn: false
    });
	$('.form_time').datetimepicker({
        language:  'pl',
        weekStart: 1,        
		autoclose: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0,
		todayBtn: false			

    });

</script>
