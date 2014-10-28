<?php

	if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']))
	{
		include_once("../../lib/Lib.php");

		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];

		$student = new Student();
		$student->setID($_POST['student_id']);
		$student->setFirstName($firstname);
		$student->setSurName($lastname);
		$student->setEmail($email);

		StudentDatabase::updateStudent($student);

		$array = [
			0 => $firstname,
			1 => $lastname,
			2 => $email
		];

		header('Content-Type: application/json');
		echo json_encode($array);
	}


?>