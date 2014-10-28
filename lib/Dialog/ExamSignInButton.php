<div class="modal fade modal-sm" id="signInModal" name="signOutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelSO" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center" id="myModalLabelSO"><b><span id="innerExamName"></span></b></h3>
			</div>
			<form name="modalForm" class="form-signin form-horizontal" id="examSignInForm" role="form" style="margin:10px; margin-right:10px;margin-left:10px" onsubmit="return validateRadio(this);" method="post" action="controler/StudentSignInOut.php">
				<div class="modal-body">
					<input name="innerIStudentID" id="innerIStudentID" type="hidden">
					<input name="innerIExamID" id="innerIExamID" type="hidden">
					<input name="innerIStudentCode" id="innerIStudentCode" type="hidden">
					<input name="innerIExamDay" id="innerIExamDay" type="hidden">
					<div id="signInBody"></div>
				</div>
				<div id="signInFooter" class="modal-footer">
				</div>
			</form>
		</div>
	</div>
</div>