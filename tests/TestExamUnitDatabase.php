<?php
	include("TestBegin.php");
	include_once('../lib/Lib.php');
	
	$testExam = new Exam;
	$testExam->setID(16);
	$testExamUnit = new ExamUnit;
	$testExamUnit->setDay('2014-04-02');
	$testExamUnit->setTimeFrom('09:00:00');
	$testExamUnit->setTimeTo('14:00:00');
	$testExamUnit->setState('unlocked');
	
	
	$Days = ExamUnitDatabase::getExamDays(15);
	echo "<br/>";
	foreach($Days as $day){
		echo $day . "<br/>";
	}
	
	$count = ExamUnitDatabase::countLockedExamUnits(15);
	echo "<br/>" . $count . "<br/>";
	
	
	$count = ExamUnitDatabase::countOpenExams(1,0);
	echo "<br/>" . $count . "<br/>";
	
	if(ExamUnitDatabase::deleteDayWithAllExamUnits(17, '2014-04-16'))
		echo "<br/> Day Deleted <br/>";
	else
		echo "<br/> Day Not Deleted <br/>";
	
	
	
	/*
	if(ExamUnitDatabase::deleteExamUnit2(17,'2014-04-09', '09:00:00'))
		echo "<br/> 2 Deleted <br/>";
	else
		echo "<br/> 2 Not Deleted <br/>";
		
	
	if(ExamUnitDatabase::deleteExamUnit(1))
		echo "Deleted <br/>";
	else
		echo "Not Deleted <br/>";	
		
	
	if(ExamUnitDatabase::insertExamUnit($testExam,$testExamUnit)){
		echo "Done and Done <br/>";
	}else{
		echo "nope <br/>";
	}
	
	$testExamUnit->setID(ExamUnitDatabase::getExamUnitID($testExam));
	
	$testExamUnit->setState('locked');
	$testExamUnit->setTimeTo('17:00:00');
	
	
	if(ExamUnitDatabase::updateExamUnit($testExamUnit)){
		echo "Updated<br/>";
	}else{
		echo "Something went Wrong<br/>";
	}
	
	
	if(ExamUnitDatabase::deleteExamUnit($testExamUnit)){
		echo "There's no more evidence of ". $testExamUnit->getID() . "<br/>";
	}else{
		echo "nope<br/>";
	}*/
	
	include("TestEnd.php");		
?>