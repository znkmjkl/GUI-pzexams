<?php
	include_once("../Lib.php");

	header("content-type:application/json");
	
	function handlingError($msg) {
		echo json_encode(array("status" => "failed", "errorMsg" => $msg, "changes" => ""));
	}
	
	function handlingSuccess1() {
		echo json_encode(array("status" => "success", "errorMsg" => "", "changes" => "0"));
	}

	function handlingSuccess2() {
		echo json_encode(array("status" => "success", "errorMsg" => "", "changes" => "1"));
	}
	

	if (!isset($_SESSION["USER"])) {
		$errorMsg = "Błąd krytyczny: użytkownik jest niezalogowany.";
		handlingError($errorMsg);
		return;
	} else {
		$user = unserialize($_SESSION["USER"]);
	}

	if (isset($_POST["examID"])) {
		
		if(isset($_POST['examName']) || isset($_POST['examDuration'])){
			if (!DatabaseConnector::isConnected()) {
				$msg = "Wystąpił błąd przy połączeniu z bazą!";
				handlingError($msg);
				return;
			}
			$exam = ExamDatabase::getExam($_POST['examID']);
			$examU = new Exam();
			$examU -> setName($_POST['examName']);
			if ($_POST['examDuration'] == 60) {
				$examU -> setDuration("01:00:00");
			} else {
				$examU -> setDuration("00:".$_POST['examDuration'].":00");
			}
			//$examU -> setDuration("00:".$_POST['examDuration'].":00");
			$examU -> setID($exam -> getID());		
			
			if( $exam -> getName() == $examU -> getName() && $exam -> getDuration() == $examU -> getDuration()){
				handlingSuccess1();				
				return;
				
			} else {
				if(ExamDatabase::UpdateExam($user -> getID(), $examU)){
					handlingSuccess2();
					return;
				}
				$errorMsg = "Błąd przy edycji egzaminu";
				handlingError($errorMsg);
				return;	
			}			
		}
		$errorMsg = "Błąd przy edycji egzaminu";
		handlingError($errorMsg);
		return;

	} else {
		$errorMsg = "Błąd krytyczny: nie dostarczono danych";
		handlingError($errorMsg);
		return;
	}

?>
