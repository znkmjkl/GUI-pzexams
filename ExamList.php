<?php
	ob_start();
	include_once("lib/Lib.php");
	
	function finish() {
		include("html/End.php");
		ob_end_flush();
	}
	
	$title = "$appName - Lista aktualnych egzaminów";
	$scripts = array("js/Lib/bootbox.min.js", "js/ExamList.js");
	include("html/Begin.php");
	
	if (!isset($_SESSION['USER']) || $_SESSION['USER'] == "") {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla zalogowanych użytkowników.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	include("html/UserPanel.php");
	
	$userID = unserialize($_SESSION['USER'])->getID();
	$exams = ExamDatabase::getExamList($userID);
	
	if ($exams == null) {
		echo "<div class=\"alert alert-info\">";
		echo "<b>Nie dodałeś jeszcze żadnych egzaminów!</b> Zobacz jakie to proste i <u><b><a href=\"AddExam.php\">utwórz</a></b></u> swój pierwszy egzamin.";
		echo "</div>";
		
		finish();
		return;
	}
	
	date_default_timezone_set('Europe/Warsaw');
	$currentDate = date("Y-m-d");
		
	// Przygotujmy posortowaną listę egzaminów względem daty rozpoczęcia
	$list = null;
	$i = 0;
	foreach ($exams as $exam) {
		$list[$i] = new ExamListElement($exam, ExamUnitDatabase::getExamDays($exam->getID()));
		$i++;
	}
	ExamListElement::sortByStartDate($list);
	
	// Sprawdzamy czy przypadkiem listę, którą będziemy wyświetlać nie będzie pusta
	$isEmpty = true;
	foreach ($list as $element) {
		$examDays = $element->getExamDates();
		$examDaysSize = sizeof($examDays);
		
		if ($examDays != null) {
			if ($currentDate < $examDays[0] || $currentDate < $examDays[$examDaysSize - 1]) {
				$isEmpty = false;
				break;
			}
		} else {
			$isEmpty = false;
			break;
		}
	}
	if ($isEmpty) {
		echo "<div class=\"alert alert-info\">";
		echo "<b>W chwili obecnej nie posiadasz żadnych aktualnych egzaminów!</b> Możesz przejrzeć <b><u><a href=\"ExamListArchives.php\">listę archiwalnych egzaminów</a></u></b> lub <b><u><a href=\"AddExam.php\">dodać nowy egzamin</a></b></u>.";
		echo "</div>";
		
		finish();
		return;
	}
		
	echo '<span id="info_if_not_empty"><h2>Lista aktualnych egzaminów</h2>';
	echo "<p>W tym miejscu możesz przejrzeć listę swoich aktualnych egzaminów.</p></span>";
	echo "<hr />";
	
	echo '
	<table class="table" id="current_exams">
		<thead>
			<tr>
				<th style="text-align: center">Lp.</th>
				<th>Nazwa</th>
				<th style="text-align: center">Data rozpoczęcia<i class="glyphicon glyphicon-chevron-down" style="margin-left: 5px"></i></th>
				<th style="text-align: center">Data zakończenia</th>
				<th style="text-align: center" title="Zapisani studenci / Wprowadzeni studenci / Liczba miejsc">Zapełnienie</th>
				<th style="text-align: center">Aktywny</th>
				<th style="text-align: center">Operacje</th>
				<th style="text-align: center">Aktywacja</th>
			</tr>
		</thead>
		<tbody>
	';
		
	$i = 1;
	foreach ($list as $element) {
		$id           = $element->getExam()->getID();
		$name         = $element->getExam()->getName();
		$activated    = $element->getExam()->getActivated();
		$examDays     = $element->getExamDates();
		$examDaysSize = sizeof($examDays);
			
		// Is actual exam check
		if ($examDays != null) {
			if ($currentDate > $examDays[0]) {
				if ($examDaysSize == 1 || $currentDate > $examDays[$examDaysSize - 1]) {
					continue;
				}
			}
		}
		
		// Row begin
		$echoRowDefault = "<tr id=\"row-id-" . $id . "\">";
		$echoRowActive  = "<tr id=\"row-id-" . $id . "\" class=\"success\">";
		$echoRowDanger  = "<tr id=\"row-id-" . $id . "\" class=\"warning\">";
		if ($examDaysSize == 0) {
			echo $echoRowDanger;
		} elseif ($examDaysSize == 1) {
			if ($examDays[0] == $currentDate) {
				echo $echoRowActive;
			} else {
				echo $echoRowDefault;
			}
		} else {
			if ($examDays[0] < $currentDate && $examDays[$examDaysSize - 1] > $currentDate) {
				echo $echoRowActive;
			} else {
				echo $echoRowDefault;
			}
		}
		
		// Lp.
		echo "<td id=\"row-lp-" . $i . "\" style=\"text-align: center;\">" . $i . ".</td>\n";
		
		// Name
		echo "<td id=\"row-name-id-" . $id . "\"><a id=\"linkS1\" href=\"ExamView.php?id=" . $id . "\" style=\"color: #000\">" . $name . "</a></td>\n";
		
		// Dates
		if ($examDays == null) {
			echo "<td style=\"text-align: center\">Brak</td>";
			echo "<td style=\"text-align: center\">Brak</td>";
		} else {
			echo "<td style=\"text-align: center\">" . $examDays[0] . "</td>";
			if ($examDaysSize == 0) {
				echo "<td style=\"text-align: center\">Brak</td>";
			} else {
				echo "<td style=\"text-align: center\">" . $examDays[$examDaysSize - 1] . "</td>";
			}
		}
		
		// Populating
		echo "<td style=\"text-align: center\"><span title=\"Liczba zapisanych studentów\">" . ExamUnitDatabase::countLockedExamUnits($id)  . "</span>/<span title=\"Liczba studentów\">" . RecordDatabase::countStudentsByExam($id) . "</span>/<span title=\"Liczba miejsc\">" . ExamUnitDatabase::countExamUnits($id) . "</span></td>";
		
		// Activated
		echo "<td id=\"row-activated-id-" . $id . "\" style=\"text-align: center;\">";
		if ($activated) {
			echo "<b style=\"color: #156815;\">Tak</b>";
		} else {
			echo "<b style=\"color: #801313;\">Nie</b>";
		}
		echo "</td>";
		
		// Options
		echo "<td style=\"text-align: center;\">" .
			 "<a href=\"ExamEdit.php?examID=" . $id . "\" id=\"row-edit-id-" . $id . "\"><i class=\"glyphicon glyphicon-pencil\" style=\"margin-right: 10px;\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edytuj egzamin\"></i></a>" . 
			 "<a href=\"ExamStudentsList.php?examID=" . $id . "\" id=\"row-user-list-id-" . $id . "\" style=\"cursor: pointer;\"><i class=\"glyphicon glyphicon-th-list\" style=\"margin-right: 10px;\" title=\"Lista studentów\"></i></a>" .
			 "<a id=\"row-delete-id-" . $id . "\" style=\"cursor: pointer;\" ><i class=\"glyphicon glyphicon-trash\" title=\"Usuń egzamin\"></i></a>";
		
		echo "</td>";
		
		// Activation
		echo "<td style=\"text-align: center;\">";
		if (!$activated) {
			echo "<button type=\"button\" id=\"row-activate-button-id-" . $id . "\" class=\"btn btn-success dropdown-toggle btn-sm\" style=\"width: 90px\" value=\"0\"><b>Aktywuj</b></button>";
		}
		else {
			echo "<button type=\"button\" id=\"row-activate-button-id-" . $id . "\" class=\"btn btn-danger dropdown-toggle btn-sm\" style=\"width: 90px\" value=\"1\"><b>Dezaktywuj</b></button>";
		}
		echo "</td>";
		
		echo "</tr>";
		
		$i++;
	}
	
	echo '
		<tbody>
	</table>
	';
	
	finish();
?>
