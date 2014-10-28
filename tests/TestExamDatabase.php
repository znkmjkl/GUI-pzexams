<?php
	include("TestBegin.php");
	
	include_once('../lib/Lib.php');
	
	$testUser = new User;
	$testUser->setID(1);
	$exam = ExamDatabase::getExamList(1);
	$examNum = ExamDatabase::countExams(1);
	
	if ($exam == null) {
		echo "Następujący test zakończył się niepowodzeniem: \"ExamDatabase::getExamDatabase(1);\"" . "<br \>";
		echo DatabaseConnector::getLastError();
	}else{
		echo $examNum . "<br/>";
		for($i=0;$i<count($exam);$i++)
			echo $exam[$i]->getID() . ", " .
			     $exam[$i]->getUserID() . ", " .
			     $exam[$i]->getName() . ", " .
			     $exam[$i]->getDuration() . ", " .
				 $exam[$i]->getActivated() . ", " .
			     $exam[$i]->getEmailsPosted() . "<br/>";
					 
		
	echo "<br/>";
		
	if(ExamDatabase::activateExam($testUser->getID(), $exam[1]->getID()))
		echo $exam[1]->getID() . " Activated status is now " . ($exam[1]->getActivated()? 0 : 1) . " <br/>";
	else
		echo "Did not work <br/>";
		
	echo "<br/>";
	
	if(ExamDatabase::PostEmail($testUser->getID(), $exam[1]->getID()))
		echo "Posted <br/>";
	else
		echo "Did not work <br/>";	
	
	echo "<br/>";
	
	if(ExamDatabase::checkIfUserHasExam(2, 15))
		echo "Has <br/>";
	else
		echo "Does not have <br/>";	
		/*
		$testExam = new Exam;
		$testExam->setName('Test');
		$testExam->setDuration('1:00:00');

		if (!ExamDatabase::checkExamName($testExam->getName())){
			echo 'start<br/>';
			ExamDatabase::deleteExam($testUser, $testExam);
			echo 'Usunięte <br/>';
		}*/
		
		//ExamDatabase::insertExam($testUser, $testExam);
	}
	
	include("TestEnd.php");
?>
