<?php
	include_once("../Lib.php");

	header("content-type:application/json");
	
	function handlingError($msg) {
		echo json_encode(array("status" => "failed", "errorMsg" => $msg, "emailsPost" => "0"));
	}
	
	function handlingSuccess1() {
		echo json_encode(array("status" => "success", "errorMsg" => "", "emailsPost" => "0"));
	}

	function handlingSuccess2() {
		echo json_encode(array("status" => "success", "errorMsg" => "", "emailsPost" => "1"));
	}
	

	$user = null;
	$code = '';
	
	if (!isset($_SESSION["USER"])) {
		$errorMsg = "Błąd krytyczny: użytkownik jest niezalogowany.";
		handlingError($errorMsg);
		return;
	} else {
		$user = unserialize($_SESSION["USER"]);
	}
	
	if (isset($_POST["examID"])) {
		$examID = $_POST["examID"];
		$exam = ExamDatabase::getExam($examID);
		
		if(!ExamDatabase::activateExam($user->getID(),$examID)){
			$errorMsg = "Błąd! Nie udało się wykonać zmiany statusu.";
			handlingError($errorMsg);
			return;
		}		
/*		if(!$exam->getEmailsPosted()){
			if(!ExamDatabase::PostEmail($user->getID(),$examID)){
				$errorMsg = "Błąd! Nie udało się wysłać emaili do studentów.";	
				handlingError($errorMsg);
				return;
			}
			$examName = $exam -> getName();

			$studentsID = RecordDatabasie::getStudentIDList($examID);
			if(sizeof($studentsID) >= 1){
				foreach($studentsID as $studentID ){
					$code = md5(microtime());
					while(StudentDatabase::addStudentCode($studentID, $code) != true){
						
					}
					$student = StudentDatabase::getStudentByID($studentID);
					
					$email = $student -> getEmail();
					$code = $student -> getCode();php
				
					$code = md5(microtime());
					$email = 'p.michal1990@gmail.com';
					$studentCodeUrl = "http://" . Settings::getAdress() . "/StudentExams.php?code=" . $code;

					$messageBody = 
						"Witaj!<br/><br/>" .
						"Zostałeś dodany do egzaminu ustnego z: <b>". $examName ."</b> na serwisie PZ-EXAMS.<br/><br/>" .
						"By dokonać zapisu kliknij w poniższy link i wybierz odpowiadający Ci termin z listy. <br/>".
						"<a href=\"" . $studentCodeUrl . "\">" . $studentCodeUrl . "</a><br/><br/>" .
						"______________________________<br/>" .
						"Pozdrawiamy - zespół PZ-Exams<br/>";
				
					mailer($email,'pz.exams@gmail.com',"PZ-Exams", "Nowy egzamin", $messageBody, true);				
				}
			}
			handlingSuccess2();
			return;
		}*/
	} else {
		$errorMsg = "Nie przekazano parametrów do wywołania ajax.";
		handlingError($errorMsg);
		return;
	}
	
	handlingSuccess1();
?>
