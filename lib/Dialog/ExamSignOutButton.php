<div class="modal fade modal-sm" id="signOutModal" name="signOutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelSO" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content container" style="background-color:#BABEC2;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center" id="myModalLabelSO"><b>Czy jesteś pewien że chesz się wypisać?</b></h3>
			</div>
			<form name="modalForm" class="form-signin form-horizontal" id="examSignOutForm" role="form" style="margin:10px; margin-right:10px;margin-left:10px" method="post" action="controler/StudentSignInOut.php">
				<div class="modal-body text-center">
					<div id="signOutBody"></div>
					<button type="submit" class="btn btn-success btn-lg" name="signOut" value="submit">Tak</button>
					<input name="innerStudentID" id="innerStudentID" type="hidden">
					<input name="innerStudentCode" id="innerStudentCode" type="hidden">
					<input name="innerExamID" id="innerExamID" type="hidden">
					<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Nie</button>
				</div>
			</form>
		</div>
	</div>
</div>