<?php
	ob_start();
	
	include_once("lib/Lib.php");
	$title = "$appName - List studentów";
	$scripts = array("js/Lib/bootbox.min.js", "js/Lib/spin.min.js", "js/Lib/ladda.min.js", "js/StudentList.js");
	include("html/Begin.php");
	
	if (!isset($_SESSION['USER']) || $_SESSION['USER'] == "") {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla zalogowanych użytkowników.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	$user = unserialize($_SESSION['USER']);
	
	if ($user->getRight()!="administrator" && $user->getRight()!="owner") {
		echo "<div class=\"alert alert-danger\"><b>Brak uprawnień</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	include("html/AdminPanel.php");

	echo "<h2>Lista studentów</h2>";
	echo "<p>W tym miejscu znajduje się lista wszystkich studentów.</p>";
	echo "<hr />";

	echo '<span style="float: right"><a class="btn btn-primary btn-sm pull-right" id="delete-students" style="cursor: pointer;" title="Usuń nieaktywnych studentów."><i class="glyphicon glyphicon-trash"></i> <b>Usuń nieaktywnych studentów</b></a></span>';

	$studentList = StudentDatabase::getAllStudents();

	if (!is_array($studentList)) {
		$displayTable = ' style="display: none;"';
	} else {
		$displayInfo = ' display: none;"';
	}

	echo '<div style="margin-top: 5%;"><h3 id="empty_list" style="text-align: center; margin-bottom: 4%;' . $displayInfo . '>Lista studentów jest obecnie pusta</h3>
		<table class="table" id="students"' . $displayTable . '>
		<thead>
			<tr>
				<th style="text-align: center;">Lp.</th>
				<th>Imię</th>
				<th>Nazwisko</th>
				<th>E-mail</th>
				<th style="text-align: center;">Jest zapisany na egzamin/y</th>
				<th style="text-align: center;">Operację</th>
			</tr>
		</thead>
		<tbody>';

	if (is_array($studentList)) {
		foreach ($studentList as $number => $student) {
			echo '<tr id="row-id-' . $student->getID() . '">';
			echo '<td id="row-lp-'. ($number+1) . '" style="text-align: center;">' . ($number+1) .  '.</td>';

			$fName = "-";
			$lName = "-";

			if ($user->getFirstName() != "") {
				$fName = $student->getFirstName();
			}

			if ($user->getSurname() != "") {
				$lName = $student->getSurname();
			}

			echo '<td id="firstname">' . $fName . '</td>';
			echo '<td id="lastname">' . $lName . '</td>';
			echo '<td id="row-email-id-' . $student->getID()  . '">' . $student->getEmail() . '</td>';
			echo '<td style="text-align: center;">';
			$examIdsList = RecordDatabase::getAssignedExamIDList($student->getID());
			if(count($examIdsList) == 0){
				echo "<b style=\"color: #801313;\">Nie</b>";
			}else{
				echo "<b style=\"color: #156815;\">Tak</b>";
			}
			echo '</td>';
			echo "<td style=\"text-align: center;\">" .
			"<a id=\"row-delete-id-" . $student->getID() . "\" style=\"cursor: pointer;\" title=\"Usuń studenta\"><i class=\"glyphicon glyphicon-trash\" ></i></a>";
			echo "</td>";
			echo '</tr>';
		}
	}

	echo '</tbody></table></div>';

	include("html/End.php");
	
	ob_end_flush();
?> 