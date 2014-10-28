<?php
	include_once("../lib/Lib.php");
	$timeo_start = microtime(true);
	ini_set("memory_limit","128M");
	$id   = $_GET['examID'];
	$exam = ExamDatabase::getExam($id);
	
	$html = '
	<h2>'.$exam->getName().'</h2>
	<table style="width:100%;" border="1">
	<thead><tr>
	<th>Lp.</th><th>Imię</th><th>Nazwisko</th><th>E-mail</th>
	</tr></thead><tbody>';
	$studentIDList = RecordDatabase::getStudentIDList($id);
	$studentList = null;
	if (is_array($studentIDList)) {
		$i = 0;
		foreach ($studentIDList as $studentID) {
			$studentList[$i++] = StudentDatabase::getStudentByID($studentID);
		}
	}
	foreach ($studentList as $number => $student) {
		$html=$html.'<tr><td  style="width:5%;">'.number_format($number+1).'</td>';
		$html=$html.'<td style="width:20%;">'.$student->getFirstName().'</td>';
		$html=$html.'<td style="width:20%;">'.$student->getSurname().'</td>';
		$html=$html.'<td style="width:30%;">'.$student->getEmail().'</td></tr>';
	}
	$html=$html.'</tbody></table>';

	$mpdf=new mPDF(); 

	$mpdf->useAdobeCJK = true;
	$mpdf->SetAutoFont(AUTOFONT_ALL);
	$stylesheet = file_get_contents('../css/mpdfstyletables.css');
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html);

	/*
	$mpdf=new mPDF('c','A4','','dejavusans',32,25,27,25,16,13); 
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->useAdobeCJK = true;
	$mpdf->SetAutoFont(AUTOFONT_ALL);
	$mpdf->list_indent_first_level = 0;
	$mpdf->WriteHTML($html,2);*/

	$mpdf->Output($exam->getName().".pdf",'D');
	
	//============================================================+
	// END OF FILE
	//============================================================+
	
	//header('Location: ../ExamStudentsList.php?examID='.$id); 
?>
