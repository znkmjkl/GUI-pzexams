<?php

	if(isset($_POST['email']))
	{
		include_once("../../lib/Lib.php");

		$email = $_POST['email'];
		$exam_id = $_POST['exam_id'];

		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];

		/*if (strpos(explode('@', $email)[0], '.') !== false) {
			$firstname = ucfirst(explode('.', $email)[0]);
			$lastname = ucfirst(explode('@', explode('.', $email)[1])[0]);
		} */

		$student = new Student();
		$student->setFirstName($firstname);
		$student->setSurName($lastname);
		$student->setEmail($email);

		if (StudentDatabase::insertStudent($student)){

			$new_student_id = DatabaseConnector::getLastInsertedID();

			$record = new Record();
			$record->setStudentID($new_student_id);
			$record->setExamID($exam_id);
			$record->setIsSent(0);

			if(RecordDatabase::insertRecord($record)) {
				//echo '<br/>Wpisano rekord';
			} else {
				//echo '<br/>Blad przy wpisywaniu rekordu';
			}

			$array = [
				0 => $new_student_id,
				1 => $firstname,
				2 => $lastname,
				3 => $email,
			];

			header('Content-Type: application/json');
			echo json_encode($array);

		} else if (StudentDatabase::getStudentID($student) != null && RecordDatabase::getRecordID($exam_id, StudentDatabase::getStudentID($student)) == null) {

			$student_id = StudentDatabase::getStudentID($student);

			$student = StudentDatabase::getStudentByID($student_id);

			$record = new Record();
			$record->setStudentID(StudentDatabase::getStudentID($student));
			$record->setExamID($exam_id);
			$record->setIsSent(0);

			if(RecordDatabase::insertRecord($record)) {
				//echo '<br/>Wpisano rekord';
			} else {
				//echo '<br/>Blad przy wpisywaniu rekordu';
			}

			$array = [
				0 => $student_id,
				1 => $student->getFirstName(),
				2 => $student->getSurName(),
				3 => $student->getEmail(),
			];

			header('Content-Type: application/json');
			echo json_encode($array);

		} else {
			header('Content-Type: application/json');
			echo json_encode(null);
		}

	}


?>