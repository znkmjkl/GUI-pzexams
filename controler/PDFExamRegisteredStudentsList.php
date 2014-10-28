<?php
	include_once("../lib/Lib.php");
	$timeo_start = microtime(true);
	ini_set("memory_limit","128M");
	$id = $_GET['examID'];
	$setting = $_GET['setting'];
	$exam = ExamDatabase::getExam($id);
	
	$examDays = ExamUnitDatabase::getExamDays($id);
	$uniqeDays = array_unique($examDays);
	$weekDays = array(1 => "Poniedziałek", 2 => "Wtorek", 3 => "Środa", 4 => "Czwartek", 5 => "Piątek", 6 => "Sobota", 0 => "Niedziela");

	function dayHasRegisteredStudents($examUnitIDList) {
		$ret = FALSE;
		foreach ($examUnitIDList as $number =>  $examUnitID) {
				$examunit = ExamUnitDatabase::getExamUnit($examUnitID);
				if($examunit->getState() == "locked"){
					$ret = TRUE;
					continue;
				}
		}
		return $ret;
	}

	if($setting == "full") {
		$html = '<h2>'.$exam->getName().'</h2>';
		foreach ($uniqeDays as $dayCount => $day) {
			$html = $html.'<h4>'.$day.' ('.$weekDays[strftime('%w',strtotime($day))].')'.'</h4>';
			$html = $html.'
			<table style="width:100%;" border="1">
			<thead><tr>
			<th>Lp.</th><th>Termin</th><th>Student</th><th>Podpis</th>
			</tr></thead><tbody>';
			$examUnitIDList = ExamUnitDatabase::getExamUnitIDListDay($id, $day);
			foreach ($examUnitIDList as $number =>  $examUnitID) {
				$examunit = ExamUnitDatabase::getExamUnit($examUnitID);
				$record = RecordDatabase::getRecordFromUnit($examUnitID);
				$html=$html.'<tr height:15px;><td style="width:5%;">'.number_format($number+1).'</td>';
				$html=$html.'<td style="width:20%;">'.$examunit->getTimeFrom().' - '. $examunit->getTimeTo().'</td>';
				if($record == NULL) {
					$html=$html.'<td style="width:25%;"></td>';
				} else {
					$student = StudentDatabase::getStudentByID($record->getStudentID());			
					if (($student->getFirstName() == NULL) || ($student->getFirstName() == "")){
						$html=$html.'<td style="width:25%;">'.$student->getEmail().'</td>';
					} else {
						$html=$html.'<td style="width:25%;">'.$student->getFirstName() .' '. $student->getSurName().'</td>';
					}
					$student = NULL;
				}
				$html=$html.'<td style="width:50%;"></td></tr>';
			}
			$html=$html.'</tbody></table>';
			if($dayCount != count($uniqeDays)-1) {
				$html=$html.'<pagebreak />';
			}
		}
	}elseif($setting == "registered"){
		$html = '<h2>'.$exam->getName().'</h2>';
		foreach ($uniqeDays as $dayCount => $day) {
			$examUnitIDListTest = ExamUnitDatabase::getExamUnitIDListDay($id, $day);
			$test = TRUE;
			foreach ($examUnitIDListTest as $examUnitIDTest) {
				$examunitTest = ExamUnitDatabase::getExamUnit($examUnitIDTest);
				if($examunitTest->getState() == "locked"){
					$test = FALSE;
				}
			}
			if($test){
				continue;
			}
			$html = $html.'<h4>'.$day.' ('.$weekDays[strftime('%w',strtotime($day))].')'.'</h4>';
			$html = $html.'
			<table style="width:100%;" border="1">
			<thead><tr>
			<th>Lp.</th><th>Termin</th><th>Student</th><th>Podpis</th>
			</tr></thead><tbody>';
			$examUnitIDList = ExamUnitDatabase::getExamUnitIDListDay($id, $day);
			foreach ($examUnitIDList as $number =>  $examUnitID) {
				$examunit = ExamUnitDatabase::getExamUnit($examUnitID);
				if($examunit->getState() == "unlocked"){
					$number = $number-1;
					continue;
				}
				$record = RecordDatabase::getRecordFromUnit($examUnitID);
				$html=$html.'<tr height:15px;><td style="width:5%;">'.number_format($number+1).'</td>';
				$html=$html.'<td style="width:20%;">'.$examunit->getTimeFrom().' - '. $examunit->getTimeTo().'</td>';
				if($record == NULL) {
					$html=$html.'<td style="width:25%;"></td>';
				} else {
					$student = StudentDatabase::getStudentByID($record->getStudentID());			
					if (($student->getFirstName() == NULL) || ($student->getFirstName() == "")){
						$html=$html.'<td style="width:25%;">'.$student->getEmail().'</td>';
					} else {
						$html=$html.'<td style="width:25%;">'.$student->getFirstName() .' '. $student->getSurName().'</td>';
					}
					$student = NULL;
				}
				$html=$html.'<td style="width:50%;"></td></tr>';
			}
			$html=$html.'</tbody></table>';
			if(($dayCount != count($uniqeDays)-1) && (!dayHasRegisteredStudents($examUnitIDList))) {
				$html=$html.'<pagebreak />';
			}
		}
	}else{
		$html = '<h1>ERROR</h1>';
	}

	$mpdf=new mPDF(); 
	$mpdf->useAdobeCJK = true;
	$mpdf->SetAutoFont(AUTOFONT_ALL);
	$stylesheet = file_get_contents('../css/mpdfstyletables.css');
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html);
	$mpdf->Output($exam->getName().".pdf",'D');
	
	//header('Location: ../ExamStudentsList.php?examID='.$id); 
?>