<?php
	ob_start();
	
	include_once("lib/Lib.php");
	
	
	// Check if user should access this page  
	$userExamList = ExamDatabase::getExamList(unserialize($_SESSION['USER'])->getID());
	$accessEditExamGranted = false ; 
	foreach ($userExamList as $exam) { 
		if ( $exam->getID() == $_GET['examID'] ) $accessEditExamGranted = true   ; 
	} 
	if ( ! $accessEditExamGranted ) header('Location: ExamList.php') ;  
	

	if (isset($_GET["examID"])) {
		$examID = $_GET["examID"];
		$exam = ExamDatabase::getExam($examID);
		if($exam -> getActivated()) header('Location: ExamList.php') ;
	}
	
	$title = "$appName - Edytuj egzamin ";
	$scripts = array( "js/Lib/bootbox.min.js", "js/CalendarManager.js" , "js/ExamEdit.js" );
	include("html/Begin.php");
	
	if (!isset($_SESSION['USER']) || $_SESSION['USER'] == "") {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla zalogowanych użytkowników.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	include("html/UserPanel.php");
?>

<div class="container col-md-12">
	<h2>Edycja Egzaminu</h2> 
	<hr style="height:1px;border:none;color:#333;background-color:#333;"/>
	<?php
 		$examName = ExamDatabase::getExam($examID)->getName();
 		$hour = substr(ExamDatabase::getExam($examID)->getDuration(),0,2) * 60;
 		$examDuration = $hour + substr(ExamDatabase::getExam($examID)->getDuration(),3,2);
 	?>
 	<script>
 		$(document).ready(function(){
 			$('#exam_duration').val("<?php Print($examDuration); ?>");
 
 		});
 	</script>
	<h3> Edycja podstawowych danych </h3>
	<form role="form" class="form-horizontal" >

		<div class="form-group" id="exam_name_group">
			<label for="exam_name" class="control-label col-sm-3 col-md-3">Nazwa egzaminu</label>
			<div class="col-sm-4 col-md-4">
				<input type="text" class="form-control" id="exam_name" placeholder="Zmień nazwę" maxlength="120" value="<?php echo $examName; ?>">
			</div>
			<span class="help-block" id="name-error"></span>
		</div>


		<div class="form-group" id="duration_group">
			<label for="duration" class="control-label col-sm-3 col-md-3">Czas trwania egzaminu (minuty)</label>
			<div class="col-sm-4 col-md-4">
				<input type="number" name="duration" class="form-control" id="exam_duration" placeholder="Zmień czas trwania" maxlength="2" min="0" max="100">
			</div>
			<span class="help-block" id="duration-error"></span>			
		</div>
		<div class="form-group">
			<span class="col-xs-2 col-sm-2 col-md-2 col-md-offset-3">
				<button class="btn btn-success" id="updateBtn">Aktualizuj zmiany</button>
			</span>
		</div>
	</form>
	<hr style="height:1px;border:none;color:#333;background-color:#333;"/>
	<p>Uwaga zmiana hramonogramu jest zapisywana bezpośrednio w bazie danych. Prosimy o rozważne modyfikowanie terminów!</p>
	<h3> Edycja harmonogramu </h3>
	<div class="row col-md-11" style="float:none;margin:0 auto;"> 
			<br />
				<div id="calendar-control"> 
				<!-- here goes calendar content --> 
				</div>
			<br />
			<?php
				include("lib/Dialog/ModalButton.php");
			?>
	</div>	
	<a class="btn btn-success pull-right" href="ExamList.php"> Powrót do listy egzaminów </a>
</div>
<hr style="height:1px;border:none;color:#333;background-color:#333;"/>


<script type="text/javascript">
	// loads calendar from database --> first CalendarManager script is  run
	$(document).ready(function () {
		editExamCalendarManager.sendAjaxExamCalendarRequest();
	});
</script>

<?php
	include("html/End.php");
	
	ob_end_flush();
?> 
