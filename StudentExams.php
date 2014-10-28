<?php
	ob_start();
	
	include_once("lib/Lib.php");
	$title = "$appName - Strona studenta - List egzaminów";
	$scripts = array("js/StudentRegister.js");
	include("html/Begin.php");
	
	$arrLocales = array('pl_PL', 'pl','Polish_Poland.28592');
	setlocale(LC_ALL, $arrLocales);
	$weekDays = array(1 => "Poniedziałek", 2 => "Wtorek", 3 => "Środa", 4 => "Czwartek", 5 => "Piątek", 6 => "Sobota", 0 => "Niedziela");
	
	echo "<input id=\"studentCode\" type=\"hidden\" value=\"";
	echo $_GET['code'];
	echo "\">";
	$student = null;
	$id = null;
	if (isset($_GET['code'])) {
		$student = StudentDatabase::getStudentByCode($_GET['code']);
		$id = $student->getID();
	}
	
	if ($id == null) {
		echo "<div class=\"alert alert-danger text-center\"><b>Kod niepoprawny.</b> Za 5 sekund zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 5; url=index.php");
		include("html/End.php");
	
		ob_end_flush();
		return;
	}
	
	$examsID = RecordDatabase::getExamIDList($student->getID());


	if	(isset($_SESSION['studentEditAlert'])){	
		if	($_SESSION['studentEditAlert']	==	'pass'){
			echo	'<div	class="alert	alert-success">';
			echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>';		
			echo	'<strong>Poprawnie	zmieniono dane osobowe.</strong>';	
			echo	'</div>';
			unset($_SESSION['studentEditAlert']);
		}elseif	($_SESSION['studentEditAlert']	==	'fail'){
			echo	'<div	class="alert	alert-danger">'	;
			echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>';		
			echo	'<strong>Coś złego stało się w bazie danych.</strong>';	
			echo	'</div>';
			unset($_SESSION['studentEditAlert']);
		};	
	}
	
	if	(isset($_SESSION['signInAlert'])){	
		if	($_SESSION['signInAlert']	==	'pass'){
			echo	'<div	class="alert	alert-success">';
			echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>';		
			echo	'<strong>Poprawnie	zapisano się na Egzamin.</strong>';	
			echo	'</div>';
			unset($_SESSION['signInAlert']);
		}elseif	($_SESSION['signInAlert']	==	'fail'){
			echo	'<div	class="alert	alert-danger">'	;
			echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>';		
			echo	'<strong>Egzamin zablokowany przez Egzaminatora.</strong>';	
			echo	'</div>';
			unset($_SESSION['signInAlert']);
		};	
	}

	if	(isset($_SESSION['signOutAlert'])){
		if	($_SESSION['signOutAlert']	==	'pass'){	
			echo	'<div	class="alert	alert-success">';
			echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>';		
			echo	'<strong>Poprawnie	wypisano się z Egzaminu.</strong>';	
			echo	'</div>';
			unset($_SESSION['signOutAlert']);
		}elseif	($_SESSION['signOutAlert']	==	'fail'){
			echo	'<div	class="alert	alert-danger">';
			echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>';		
			echo	'<strong>Egzamin zablokowany przez Egzaminatora</strong>';	
			echo	'</div>';
			unset($_SESSION['signOutAlert']);
		};	
	}
	
	//echo '<pre>'; print_r($examsID); echo '</pre>';
	echo "<input id=\"studentID\" type=\"hidden\" value=\"";
	echo $id;
	echo "\">";
	echo "<span id=\"valueField\"></span>";

	if(($student->getFirstName() == NULL) || ($student->getFirstName() == "")){
		echo "<h2><span>Lista aktualnych egzaminów użytkownika: ". $student->getEmail() ."</span>";
		$_SESSION['studentNameAlert'] = 'alert';
	}else{
		echo "<h2><span>Lista aktualnych egzaminów użytkownika: ".$student->getFirstName()." ".$student->getSurName()."</span>";
	}
	echo "<span style=\"float: right;\">";
	if	(isset($_SESSION['studentNameAlert'])){
		echo '<span style="background-color:#F13333;" class="badge pull-left" title="Ustaw swoje Imię i Nazwisko">!</span>';
		unset($_SESSION['studentNameAlert']);
	}
	echo "<a href=\"#\" data-toggle=\"modal\" name=\"studentEditGlyph\" id=\"studentEditGlyph\" data-target=\"#studentEditModal\" title=\"Edytuj dane osobowe\" value=\"".$student->getID()."\"><i class=\"glyphicon glyphicon-cog h2\"></i></a></span>";
	echo "</h2>";
	echo "<p>W tym miejscu możesz przejrzeć listę swoich aktualnych egzaminów.</p>";
	echo "<hr />";
	
		echo '
		<table class="table table-hover table-condensed text-left">
			<thead>
				<tr>
					<th><center>Lp.</center></th>
					<th>Data Egzaminu</th>
					<th>Nazwa Egzaminu</th>
					<th><center>Status</center></th>
					<th><center>Zapisz/Wypisz się</center></th>
				</tr>
			</thead>
			<tbody>
		';
	
		$i = 1;
		foreach ($examsID as $examID) {
			$exam = ExamDatabase::getExam($examID);
			$examDays = ExamUnitDatabase::getExamDays($examID);
			if (date_create($examDays[count($examDays)-1]) > new DateTime("now")) {
				$examUnitList = ExamUnitDatabase::getExamUnitIDList($exam);
				$examUnitID=RecordDatabase::getExamUnitID($examID,$id);
				if ((($examUnitID) != null)&&(($examUnitID) != 0)) {	
					echo "<tr class=\"info\">";
				}elseif(!($exam->getActivated())){
					echo "<tr class=\"active\">";
				}else{
					echo "<tr class=\"danger\">";
				}
				echo "<td class=\"text-center\" style=\"vertical-align:middle;\">" . $i . ".</td>\n";
				// Dni aktywności egzamninu.
				if ((($examUnitID) != null)&&(($examUnitID) != 0)) {
					echo "<td style=\"vertical-align:middle;\"><b>";
					$eu = ExamUnitDatabase::getExamUnit($examUnitID);
					echo $eu->getDay();
					$time = $eu->getDay()." ".$eu->getTimeFrom();
					//echo " (".iconv("ISO-8859-2","UTF-8",ucfirst(strftime('%A',strtotime($time)))).") ";
					echo "(".$weekDays[strftime('%w',strtotime($time))].")";
					echo " o ".strftime("%H:%M",strtotime($time));
					echo "</b>";
				}else{
					echo "<td style=\"vertical-align:middle;\">";
					$j = 0;
					$uniqeDays = array_unique($examDays);
					$startDay = null;
					//echo '<pre>'; print_r($uniqeDays); echo '</pre>';
					foreach ($uniqeDays as $day){
						if($j == 0){
							$startDay = $day;
							echo $day;
						}elseif($j == count($uniqeDays)-1){
							if(date("Y",strtotime($day)) != date("Y",strtotime($startDay))){
								echo " do ".date("Y-m-d",strtotime($day));
							}elseif(date("m",strtotime($day)) != date("m",strtotime($startDay))){
								echo " do ".date("m-d",strtotime($day));
							}elseif(date("d",strtotime($day)) != date("d",strtotime($startDay))){
								echo "/".date("d",strtotime($day));
							}
						}
						$j++;
					}
				}
				echo "</td>";
				echo '<td style="vertical-align:middle;"><a id="linkS2" style="color: #000" href="StudentExamsList.php?code='. $_GET['code'] . '&exam=' . $examID . '">' . $exam->getName() . '</a></td>';
				//Liczba osób zapisanych
				$locked = ExamUnitDatabase::countLockedExamUnits($examID);
				$total = count($examUnitList);
				$percent = ((100*$locked)/count($examUnitList));
				// Zapisany
				if (!($exam->getActivated())){
					echo "<td  class=\"col-md-3\"><div class=\"progress fake-center\">";
					echo "<div class=\"progress-bar progress-bar-danger\" role=\"progressbar\" aria-valuenow=\"$percent\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 0%\">";
					echo "<span><b style=\"vertical-align:middle;\">Edycja zablokowana</b></span>";
					echo "</div></div></td>";
					// Zapisz się (Button z id egzaminu)
					echo "<td class=\"text-center\">";
					echo "<a class=\"btn btn-info fake-center-button\" href=\"#\" role=\"button\" disabled=\"disabled\" data-toggle=\"modal\" name=\"signInGlyph\" id=\"signInGlyph\" data-target=\"#signInModal\" title=\"Zapisz się\" value=\"".$exam->getID()."\" examname=\"". $exam->getName() ."\"><i class=\"glyphicon glyphicon-asterisk\"></i></a>";
					echo "</td>";
				}elseif((($examUnitID) != null)&&(($examUnitID) != 0)){
					echo "<td  class=\"col-md-3\"><div class=\"progress fake-center\">";
					echo "<div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"$percent\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $percent%\">";
					echo "<span style=\"height:20px;\"><b style=\"vertical-align:middle;\">$locked/$total - Zapisany</b></span>";
					echo "</div></div></td>";
					// Wypisz się (Button z id egzaminu)
					echo "<td class=\"text-center\">";
					echo "<a class=\"btn btn-danger fake-center-button\" href=\"#\" role=\"button\" data-toggle=\"modal\" id=\"signOutGlyph\" data-target=\"#signOutModal\" title=\"Wypisz się\" value=\"".$exam->getID()."\"><i class=\"glyphicon glyphicon-remove\"></i></a>";
					echo "</td>";
				}elseif($total != $locked){
					echo "<td  class=\"col-md-3\"><div class=\"progress fake-center\">";
					echo "<div class=\"progress-bar progress-bar-warning\" role=\"progressbar\" aria-valuenow=\"$percent\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $percent%\">";
					echo "<span><b style=\"vertical-align:middle;\">$locked/$total - Niezapisany</b></span>";
					echo "</div></div></td>";
					// Zapisz się (Button z id egzaminu)
					echo "<td class=\"text-center\">";
					echo "<a class=\"btn btn-success fake-center-button\" href=\"#\" role=\"button\" data-toggle=\"modal\" id=\"signInGlyph\" data-target=\"#signInModal\" title=\"Zapisz się\" value=\"".$exam->getID()."\" examname=\"". $exam->getName() ."\"><i class=\"glyphicon glyphicon-plus\"></i></a>";
					echo "</td>";
				}else{
					echo "<td  class=\"col-md-3\"><div class=\"progress fake-center\">";
					echo "<div class=\"progress-bar progress-bar-danger\" role=\"progressbar\" aria-valuenow=\"$percent\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $percent%\">";
					echo "<span><b style=\"vertical-align:middle;\">$locked/$total - Niezapisany - Brak Miejsc</b></span>";
					echo "</div></div></td>";
					// Zapisz się (Button z id egzaminu)
					echo "<td class=\"text-center\">";
					echo "<a class=\"btn btn-success fake-center-button\" href=\"#\" role=\"button\" disabled=\"disabled\" data-toggle=\"modal\" name=\"signInGlyph\" id=\"signInGlyph\" data-target=\"#signInModal\" title=\"Zapisz się\" value=\"".$exam->getID()."\" examname=\"". $exam->getName() ."\"><i class=\"glyphicon glyphicon-plus\"></i></a>";
					echo "</td>";
				}
			$i++;
			}
		}
	
	echo '
		<tbody>
	</table>
	';

	include_once("lib/Dialog/StudentEditModal.php");
	include_once("lib/Dialog/ExamSignOutButton.php");
	include_once("lib/Dialog/ExamSignInButton.php");
	include("html/End.php");
?>