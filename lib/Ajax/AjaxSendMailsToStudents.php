<?php
	include_once("../Lib.php");

	header("content-type:application/json");
	
	function handlingError($msg) {
		echo json_encode(array("status" => "failed", "errorMsg" => $msg, "changes" => ""));
	}
	
	function handlingSuccess1() {
		echo json_encode(array("status" => "success", "errorMsg" => "", "send" => "0"));
	}
	function handlingSuccess2() {
		echo json_encode(array("status" => "success", "errorMsg" => "", "send" => "1"));
	}	


	if (!isset($_SESSION["USER"])) {
		$errorMsg = "Błąd krytyczny: użytkownik jest niezalogowany.";
		handlingError($errorMsg);
		return;
	} else {
		$user = unserialize($_SESSION["USER"]);
	}

	if(isset($_POST['examID']) && isset($_POST['mails']) && $_POST['mails'] == 1){
		if (!DatabaseConnector::isConnected()) {
			$msg = "Wystąpił błąd przy połączeniu z bazą!";
			handlingError($msg);
			return;
		}
		$studentsID = RecordDatabase::getStudentIDList($_POST['examID']);
		$examName = ExamDatabase::getExam($_POST['examID'])->getName();
		if(sizeof($studentsID) >= 1){
			foreach($studentsID as $studentID ){
				$student = StudentDatabase::getStudentByID($studentID);
				/*if( $student -> getCode() == NULL || $student -> getCode() == 0 ){
					$code = md5(microtime());
					while(StudentDatabase::addStudentCode($studentID, $code) != true){
						$code = md5(microtime());
					}	
					$student = StudentDatabase::getStudentByID($studentID);
				}		*/		
				
				$email = $student -> getEmail();
				$code = $student -> getCode();
			
				$studentCodeUrl = "http://" . Settings::getAdress() . "/StudentExams.php?code=" . $code;
				$messageBody = 
					"Witaj!<br/><br/>" .
					"Zostałeś dodany do egzaminu ustnego z: <b>". $examName ."</b> na serwisie PZ-EXAMS.<br/><br/>" .
					"By dokonać zapisu kliknij w poniższy link i wybierz odpowiadający Ci termin z listy. <br/>".
					"<a href=\"" . $studentCodeUrl . "\">" . $studentCodeUrl . "</a><br/><br/>" .
					"______________________________<br/>" .
					"Pozdrawiamy - zespół PZ-Exams<br/>";
			
							
				if(!mailer($email,'cos nieistotnego',"PZ-Exams", "Nowy egzamin", $messageBody, true)){
					$msg = "Wystąpił błąd przy wysyłaniu maili!";
					handlingError($msg);
				}
				if(!(RecordDatabase::messageSent($studentID, $_POST['examID']))){
					$msg = "Wystąpił błąd przy zmianie danych w bazie";
					handlingError($msg);
				}

			}
		}
		handlingSuccess1();
		return;
	}
	else if(isset($_POST['examID']) && isset($_POST['studentID'])){
		if (!DatabaseConnector::isConnected()) {
			$msg = "Wystąpił błąd przy połączeniu z bazą!";
			handlingError($msg);
			return;
		}
		$exam = ExamDatabase::getExam($_POST['examID']);
		$student = StudentDatabase::getStudentByID($_POST['studentID']);

		/*if($student -> getCode() == NULL){
			$code = md5(microtime());
			while(StudentDatabase::addStudentCode($student->getID(), $code) != true){
						$code = md5(microtime());
			}	
			$student = StudentDatabase::getStudentByID($student->getID());
		}*/

		$examName = $exam -> getName();					
		$email = $student -> getEmail();
		$code = $student -> getCode();
		


		if($student->getFirstName() == NULL){
			$imie = "";
		} else {
			$imie = " ".$student -> getFirstName();	
		}
		

		$studentCodeUrl = "http://" . Settings::getAdress() . "/StudentExams.php?code=" . $code;

		$messageBody = 	"Witaj".$imie."!<br/><br/>" .
						"Zostałeś dodany do egzaminu ustnego z: <b>". $examName ."</b> na serwisie PZ-EXAMS.<br/><br/>" .
						"By dokonać zapisu kliknij w poniższy link i wybierz odpowiadający Ci termin z listy. <br/>".
						"<a href=\"" . $studentCodeUrl . "\">" . $studentCodeUrl . "</a><br/><br/>" .
						"______________________________<br/>" .
						"Pozdrawiamy - zespół PZ-Exams<br/>";
			
				
		if(mailer($email,'cos nieistotnego',"PZ-Exams", "Nowy egzamin", $messageBody, true)){
			if(!(RecordDatabase::messageSent($_POST['studentID'], $_POST['examID']))){
				$msg = "Wystąpił błąd przy zmianie danych w bazie";
				handlingError($msg);
			}
			handlingSuccess2();
			return;
		} else {
			$msg = "Wystąpił błąd przy wysyłaniu maila!";
			handlingError($msg);
			return;
		}		
	} else {
		$msg = "Nie podano podstawowych parametrow";
		handlingError($msg);
		return;
	}



?>
