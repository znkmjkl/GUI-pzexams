<?php
	include_once("../Lib.php");
	header("content-type:application/json");
	
	function handlingError($msg) {
		echo json_encode(array("status" => "failed", "errorMsg" => $msg));
	}
	
	function handlingSuccess() {
		echo json_encode(array("status" => "success", "errorMsg" => ""));
	}
	
	$id = -1;
	$user = null;
	
	if (!isset($_SESSION["USER"])) {
		$errorMsg = "Błąd krytyczny: użytkownik jest niezalogowany.";
		handlingError($errorMsg);
		return;
	} else {
		$user = unserialize($_SESSION["USER"]);
	}
	
	if (!isset($_POST["ID"])) {
		$errorMsg = "Nie przekazano parametrów do zapytania Ajax.";
		handlingError($errorMsg);
		return;
	} else {
		$id = $_POST["ID"];
	}
	
	if (!ExamDatabase::deleteExam($user->getID(), $id)) {
		$errorMsg = "Nie udało się usunąć egzaminu.";
		handlingError($errorMsg);
		return;
	}
	
	handlingSuccess();
?>
