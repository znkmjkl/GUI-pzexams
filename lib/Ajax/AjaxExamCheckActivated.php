<?php
	include_once("../Lib.php");

	header("content-type:application/json");
	
	function handlingError($msg) {
		echo json_encode(array("status" => "failed", "errorMsg" => $msg, "activated" => ""));
	}
	
	function handlingSuccess1() {
		echo json_encode(array("status" => "success", "errorMsg" => "", "activated" => "1"));
	}

	function handlingSuccess2() {
		echo json_encode(array("status" => "success", "errorMsg" => "", "activated" => "0"));
	}
	


	if (isset($_POST["examID"])) {
		$examID = $_POST["examID"];
		$exam = ExamDatabase::getExam($examID);
		$act = $exam -> getActivated();
		if($act == 1){
			handlingSuccess1();
			return;
		} else if ($act == 0) {
			handlingSuccess2();
			return;
		} else {
			$msg = "Wystąpił błąd! Nie wprowadzono danych.";
			handlingError($msg);
			return;
		}
	} else {
		$msg = "BŁĄD!";
		handlingError($msg);
		return;
	}

?>
