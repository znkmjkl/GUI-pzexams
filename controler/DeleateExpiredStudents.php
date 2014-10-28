<?php
	include_once("../lib/Lib.php");

	$studentList = StudentDatabase::getAllStudents();
	foreach ($studentList as $student) {
		$examIdsList = RecordDatabase::getExamIDList($student->getID());
		$expired = TRUE;
		foreach($examIdsList as $examId){
			$exam = ExamDatabase::getExam($examId);
			$examDays = ExamUnitDatabase::getExamDays($examId);
			//echo $student->getID()." | ".$examDays[count($examDays)-1]."<br>";
			if (date_create($examDays[count($examDays)-1]) > new DateTime("now")) {
				//echo "<br>HIT!<br>";
				$expired = FALSE;
			}
		}
		if($expired){
			StudentDatabase::deleteStudent($student->getID());
		}
	}
	header('Location: ../AdminStudents.php'); 
?>