<?php
	include_once("lib/Lib.php");
	
	$title = "$appName - Widok egzaminu";
	include("html/Begin.php");
	
	if (!isset($_GET['exam']) || !isset($_GET['code'])) {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla przypisanych studentów.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");

		ob_end_flush();
		return;
	}

	$id   = $_GET['exam'];
	$student = StudentDatabase::getStudentByCode($_GET['code']);
	$recId = RecordDatabase::getRecordID($id, $student->getID());
	if ($recId == null) {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla przypisanych studentów.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
	
		ob_end_flush();
		return;
	}
	
	$exam = ExamDatabase::getExam($id);
	$examDays = ExamUnitDatabase::getExamDays($id);
	echo "<h2>";
	echo "<span>Informacje o egzaminie</span>";
	if ($examDays != null) {
		echo "<span style=\"float: right\"><a class=\"btn btn-primary btn-sm pull-right\" href=\"StudentExams.php?code=".$_GET['code']."\" title=\"Wróć do poprzedniej strony.\"><i class=\"glyphicon glyphicon-home\"></i> <b>Powrót</b></a></span>";
	}
	echo "</h2>";
	echo "<h4><i>(" . $exam->getName() . ")</i></h4><hr>";
	
	if ($examDays == null) {
		echo "<div class=\"alert alert-warning\"><strong>Niestety egzamin nie posiada aktualnie żadnych terminów!</strong></div>";

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
	$currentStudent = StudentDatabase::getStudentByCode($_GET['code']);
	foreach ($examUnitIDList as $examUnitID) {
		$examunit = ExamUnitDatabase::getExamUnit($examUnitID);
		$record = RecordDatabase::getRecordFromUnit($examUnitID);
		
		$bold = "";
		if ($record != NULL) {
			$student = StudentDatabase::getStudentByID($record->getStudentID());
			if ($student->getID() == $currentStudent->getID()) {
				echo "<tr class=\"row success\">";
				$bold = "font-weight:bold;";
			} else
				echo "<tr class=\"row\">";
		}
		else {
			echo "<tr class=\"row\">";
		}
		
		echo "<td class=\"text-center col-md-1\" style=\"vertical-align:middle; $bold\">" . $i . ".</td>\n";
		echo "<td class=\"col-md-2\" style=\"vertical-align:middle; $bold\">" . $examunit->getTimeFrom()." - ". $examunit->getTimeTo() . "</td>\n";

		
		if($record == NULL)
			echo "<td class=\"col-md-9\" style=\"vertical-align:middle;\"> ----- </td>\n";
		else {
			$student = StudentDatabase::getStudentByID($record->getStudentID());
			
			if(($student->getFirstName() == NULL) || ($student->getFirstName() == "")){
				if ($student->getID() == $currentStudent->getID()){				
					echo "<td class=\"col-md-9\" style=\"vertical-align:middle;font-weight:bold;text-decoration:underline;\">" . $student->getEmail() . "</td>\n";
				} else {
					echo "<td class=\"col-md-9\" style=\"vertical-align:middle;\">" . $student->getEmail() . "</td>\n";
				}

			} else {
				if ($student->getID() == $currentStudent->getID()) {
					echo "<td class=\"col-md-9\" style=\"vertical-align:middle; font-weight:bold;\">" . $student->getFirstName() . " " . $student->getSurName() . "</td>\n";
				} else {
					echo "<td class=\"col-md-9\" style=\"vertical-align:middle;\">" . $student->getFirstName() . " " . $student->getSurName() . "</td>\n";
				}
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
