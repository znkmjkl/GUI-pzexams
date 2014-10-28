<?php

	if(isset($_POST['student_id']) && isset($_POST['exam_id']))
	{
		include_once("../../lib/Lib.php");

		$result_info = false;

		$exam_id = $_POST['exam_id'];
		$student_id = $_POST['student_id'];

		$record = new Record();
		$record->setID(RecordDatabase::getRecordID($exam_id, $student_id));

		header('Content-Type: application/json');

		if(RecordDatabase::deleteRecord($record)) {
			$result_info = true;
		} else {
			$result_info = false;
		}

		echo json_encode($result_info);

	}


?>