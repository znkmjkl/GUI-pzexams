<div class="modal fade modal-sm" id="studentListPDFModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelSO" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content container">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center" id="myModalLabelSO"><b>Wybierz typ PDFa</b></h3>
			</div>
			<form name="modalForm" class="form-signin form-horizontal" id="studentListPDFForm" role="form" style="margin:10px; margin-right:10px;margin-left:10px" method="post" action="">
				<div class="modal-body text-center">
					<div class="form-group">
						<label for="duration" class="col-sm-5 control-label">Pełny Egzamin</label>
						<div class="col-sm-2">
							<?php
								echo "<a class=\"btn btn-primary btn-sm pull-right\" href=\"controler/PDFExamRegisteredStudentsList.php?examID=".$exam->getID()."&setting=full\" role=\"button\" name=\"examRegisteredStudentsListPDFGlyph\" id=\"examRegisteredStudentsListPDFGlyph\" title=\"Pobierz PDF\" value=\"".$exam->getID()."\"><i class=\"glyphicon glyphicon-download\"></i> <b>PDF</b></a>";
							?>
						</div>
					</div>
					<?php
					if(ExamUnitDatabase::countLockedExamUnits($exam->getID()) > 0){
					echo '<div class="form-group">
						<label for="duration" class="col-sm-5 control-label">Tylko zapisani studenci</label>
						<div class="col-sm-2">';
								echo "<a class=\"btn btn-primary btn-sm pull-right\" href=\"controler/PDFExamRegisteredStudentsList.php?examID=".$exam->getID()."&setting=registered\" role=\"button\" name=\"examRegisteredStudentsListPDFGlyph\" id=\"examRegisteredStudentsListPDFGlyph\" title=\"Pobierz PDF\" value=\"".$exam->getID()."\"><i class=\"glyphicon glyphicon-download\"></i> <b>PDF</b></a>";
							
					echo	'</div>
					</div>';
					}
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
				</div>
			</form>
		</div>
	</div>
</div>
