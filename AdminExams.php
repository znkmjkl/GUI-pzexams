<?php
	ob_start();
	
	include_once("lib/Lib.php");
	$title = "$appName - List studentów";
	$scripts = array("js/Lib/bootbox.min.js", "js/Lib/spin.min.js", "js/Lib/ladda.min.js", "js/ExpiredExams.js");
	include("html/Begin.php");
	
	if (!isset($_SESSION['USER']) || $_SESSION['USER'] == "") {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla zalogowanych użytkowników.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
	
		ob_end_flush();
		return;
	}
	
	$user1 = unserialize($_SESSION['USER']);
	
	if ($user1->getRight()!="administrator" && $user1->getRight()!="owner") {
		echo "<div class=\"alert alert-danger\"><b>Brak uprawnień</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	include("html/AdminPanel.php");

	echo "<h2>Lista egzaminów</h2>";
	echo "<p>W tym miejscu znajduje się lista wszystkich egzaminów.</p>";
	echo "<hr />";

	echo '<span style="float: right"><a class="btn btn-primary btn-sm pull-right" id="delete-exams" style="cursor: pointer;" title="Usuń przedawnione egzaminy."><i class="glyphicon glyphicon-trash"></i> <b>Usuń przedawnione egzaminy</b></a></span>';
	
	$exams = ExamDatabase::getAllExams();
	
	$list = null;
	$i = 0;
	foreach ($exams as $exam) {
		$examList[$i] = new ExamListElement($exam, ExamUnitDatabase::getExamDays($exam->getID()));
		$i++;
	}
	ExamListElement::sortByStartDate($examList);
	
	if (!is_array($examList)) {
		$displayTable = ' style="display: none;"';
	} else {
		$displayInfo = ' display: none;"';
	}
	
	//echo '<pre>'; print_r($examList); echo '</pre>';
	
	echo '<div style="margin-top: 5%;"><h3 id="empty_list" style="text-align: center; margin-bottom: 4%;' . $displayInfo . '>Lista studentów jest obecnie pusta</h3>
		<table class="table" id="students"' . $displayTable . '>
		<thead>
			<tr>
				<th style="text-align: center;">Lp.</th>
				<th>Nazwa</th>
				<th style="text-align: center">Data rozpoczęcia<i class="glyphicon glyphicon-chevron-down" style="margin-left: 5px"></i></th>
				<th style="text-align: center">Data zakończenia</th>
				<th>Egzaminator</th>
			</tr>
		</thead>
		<tbody>';
	
	if (is_array($examList)) {
		foreach ($examList as $number => $exam) {
			$examDays     = $exam->getExamDates();
			$examDaysSize = sizeof($examDays);
				
			// Is actual exam check
			if ($examDays != null) {
				if ($currentDate > $examDays[0]) {
					if ($examDaysSize == 1 || $currentDate > $examDays[$examDaysSize - 1]) {
						continue;
					}
				}
			}
			
			$dayte = new DateTime("now");
			echo '<tr style=\"color: #000;\" id="' . $exam->getExam()->getID() . '"';
			if($examDays[$examDaysSize - 1] < date("Y-m-d")){
				if (!$examDaysSize == 0) {
					echo "class=\"danger\">";
				}else{
					echo "class=\"warning\">";
				}
			}elseif($examDays[0] < date("Y-m-d")){
					echo "class=\"success\">";
				}else{
					echo "class=\"warning\">";
			}
			
			echo '<td id="number" style="text-align: center;">' . ($number+1) .  '.</td>';
			echo "<td id=\"name\"><a href=\"ExamView.php?id=" . $exam->getExam()->getID() . "\" ";
			echo "style=\"color: #000;\">";
			echo $exam->getExam()->getName() . "</a></td>";
			$j = 0;
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
			echo '</td>';
			$examinator = UserDatabase::getUser($exam->getExam()->getUserID());
			echo '<td id="examinator">' . $examinator->getFirstName() . " " . $examinator->getSurname() . '</td>';
			echo '</tr>';
		}
	}
	
	echo '</tbody></table></div>';
	
	include("html/End.php");
	
	ob_end_flush();
?> 