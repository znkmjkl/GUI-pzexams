<?php
	include_once("lib/Lib.php");
	
	$title = "$appName - Widok egzaminu";
	include("html/Begin.php");
	
	if (!isset($_SESSION['USER']) || $_SESSION['USER'] == "") {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla zalogowanych użytkowników.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
	
		ob_end_flush();
		return;
	}
	$user1 = unserialize($_SESSION['USER']);
	$id   = $_GET['id'];
	
	if ($user1->getRight()!="examiner" && !(ExamDatabase::checkIfUserHasExam($user1->getID(),$id))) {
		include("html/AdminPanel.php");
		
		if (!isset($_GET['id'])) {
			include("html/End.php");
			return;
		}
	}else{
		include("html/UserPanel.php");
		
		if (!isset($_GET['id'])) {
			include("html/End.php");
			return;
		}
		
		$userExamList = ExamDatabase::getExamList(unserialize($_SESSION['USER'])->getID());
		$accessEditExamGranted = false; 
		foreach ($userExamList as $exam) { 
			if ( $exam->getID() == $_GET['id'] ) $accessEditExamGranted = true; 
		} 
		if (!$accessEditExamGranted)
			header('Location: ExamList.php');
	}
	
	
	$exam = ExamDatabase::getExam($id);
	$examDays = ExamUnitDatabase::getExamDays($id);
	echo "<h2>";
	echo "<span>Informacje o egzaminie</span>";
	if ($examDays != null) {
		echo "<span style=\"float: right\"><a class=\"btn btn-primary btn-sm pull-right\" href=\"#\" data-toggle=\"modal\" name=\"examRegisteredStudentsListPDFGlyph\" id=\"examRegisteredStudentsListPDFGlyph\" data-target=\"#studentListPDFModal\" title=\"Pobierz PDF\" value=\"".$exam->getID()."\"><i class=\"glyphicon glyphicon-download\"></i> <b>PDF</b></a></span>";
	}
	echo "</h2>";
	echo "<h4><i>(" . $exam->getName() . ")</i></h4><hr>";
	
	if ($examDays == null) {
		if (!$exam->getActivated()) {
			echo "<div class=\"alert alert-info\"><strong>Niestety twój egzamin nie posiada aktualnie żadnych terminów!</strong> Możesz je dodać przechodząc do podstrony z <a class=\"alert-link\"  href=\"ExamEdit.php?examID=" . $id . "\">edycją egzaminu</a>.</div>";
		} else {
			echo "<div class=\"alert alert-warning\"><strong>Niestety twój egzamin nie posiada aktualnie żadnych terminów!</strong> Możesz je dodać przechodząc do podstrony z edycją egzaminu, ale najpierw musisz go dezaktywować w <a class=\"alert-link\" href=\"ExamList.php\">liście z aktualnymi egzaminami</a>.</div>";
		}
		
		include("html/End.php");
		
		return;
	}

	$uniqeDays = array_unique($examDays);
	$weekDays = array(1 => "Poniedziałek", 2 => "Wtorek", 3 => "Środa", 4 => "Czwartek", 5 => "Piątek", 6 => "Sobota", 0 => "Niedziela");
	
	foreach ($uniqeDays as $day) {
	echo "<h4 class=\"bg-info\">".$day." (".$weekDays[strftime('%w',strtotime($day))].")</h4>";
	echo '
		<table class="table table-condensed text-left">
			<thead>
				<tr class="row">
					<th class="col-md-1"><center>Lp.</center></th>
					<th class="col-md-2">Termin</th>
					<th class="col-md-8">Student</th>
				</tr>
			</thead>
			<tbody>
		';
	
	$i = 1;
	
	$examUnitIDList = ExamUnitDatabase::getExamUnitIDListDay($id, $day);

	foreach ($examUnitIDList as $examUnitID) {
		echo "<tr class=\"row\">";
		echo "<td class=\"text-center col-md-1\" style=\"vertical-align:middle;\">" . $i . ".</td>\n";

		$examunit = ExamUnitDatabase::getExamUnit($examUnitID);
		echo "<td class=\"col-md-2\" style=\"vertical-align:middle;\">" . $examunit->getTimeFrom()." - ". $examunit->getTimeTo() . "</td>\n";

		$record = RecordDatabase::getRecordFromUnit($examUnitID);
		if($record == NULL){
			echo "<td class=\"col-md-9\" style=\"vertical-align:middle;\"> ----- </td>\n";
		} else {
			$student = StudentDatabase::getStudentByID($record->getStudentID());
			if(($student->getFirstName() == NULL) || ($student->getFirstName() == "")){
				echo "<td class=\"col-md-9\" style=\"vertical-align:middle;\">" . $student->getEmail() . "</td>\n";
			} else {
				echo "<td class=\"col-md-9\" style=\"vertical-align:middle;\">" . $student->getFirstName() . " " . $student->getSurName() . "</td>\n";
			}
			$student = NULL;
		}

		$i++;
	}
	echo '
		<tbody>
	</table>
	<hr>
	';
	}

	include("lib/Dialog/StudentListPDFModal.php");
	include("html/End.php");
?>

