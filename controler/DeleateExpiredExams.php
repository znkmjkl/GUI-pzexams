<?php
	include_once("../lib/Lib.php");

	$examList = ExamDatabase::getAllExams();
	if (is_array($examList)) {
		foreach ($examList as $exam) {
			$examDays = ExamUnitDatabase::getExamDays($exam->getID());
			if(date_create($examDays[count($examDays)-1]) < new DateTime("now")){
				ExamDatabase::deleteExam($exam->getUserID(), $exam->getID());
			}
		}
	}

	header('Location: ../AdminExams.php'); 
?>