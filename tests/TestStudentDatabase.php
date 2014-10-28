<?php
	include("TestBegin.php");
	
	include_once('../lib/Lib.php');
	
	$testStudents[0] = new Student;	
	$testStudents[0]->setEmail('test1@test.pl');
	$testStudents[0]->setFirstName('a');
	$testStudents[0]->setSurName('aa');
	
	if(StudentDatabase::insertStudent($testStudents[0])){
		echo "Done and Done <br/>";
	}else{
		echo "nope <br/>";
	}
	
	$testStudents[0]->setID(StudentDatabase::getStudentID($testStudents[0]));	
	$testStudents[0]->setFirstName('k');
	
	if(StudentDatabase::updateStudent($testStudents[0])){
		echo "Updated<br/>";
	}else{
		echo "Something went Wrong<br/>";
	}
	
	if(StudentDatabase::addStudentCode($testStudents[0]->getID(), strval(md5(microtime())))){
		echo "Code added <br/>";
	}else{
		echo "Code has failed <br/>";
	}
	
	if(StudentDatabase::addStudentCode($testStudents[0]->getID(), strval(md5(microtime())))){
		echo "Code added <br/>";
	}else{
		echo "Code has failed <br/>";
	}
		
	if(StudentDatabase::deleteStudent($testStudents[0])){
		echo "There's no more evidence of ". $testStudents[0]->getID() . "<br/>";
	}else{
		echo "nope<br/>";
	}

	
	include("TestEnd.php");
?>
