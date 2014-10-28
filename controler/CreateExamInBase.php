<?php

include_once("../lib/Lib.php");

header("content-type:application/json");

function setResponseMessage($msg, $status) {
		echo json_encode(array("status" => $status, "errorMsg" => $msg));
}

if (!isset($_SESSION["USER"])) {
	setResponseMessage('Błąd krytyczny: użytkownik jest niezalogowany.', 'error');
	return;
}

if(isset($_POST['exam_name']) && isset($_POST['exam_duration'])) {
	if (!DatabaseConnector::isConnected()) {
			setResponseMessage('Wystąpił błąd przy połączeniu z bazą!', 'error');
			return;
	}

	$exam = new Exam();
	$userID = unserialize($_SESSION['USER'])->getID();

	$exam->setName($_POST['exam_name']);
	
	if ($_POST['examDuration'] == 60) {
		$exam -> setDuration("01:00:00");
	} else {
		$exam -> setDuration("00:".$_POST['examDuration'].":00");
	}
		
	$exam->setActivated(0);

	if (ExamDatabase::insertExam($userID, $exam)) {
		$new_exam_id = DatabaseConnector::getLastInsertedID();

		addUnits($new_exam_id);

		addStudents($new_exam_id);

		setResponseMessage('Pomyślnie dodano egzamin', 'success');
		return;
	} else {
		setResponseMessage('Wystapił błąd podczas wpisywania danych do bazy.', 'error');
		return;
	}

	echo json_encode(true);

	}

function addStudents($exam_id)
{

if(isset($_POST['students_emails']) && isset($_POST['firstnames']) && isset($_POST['lastnames'])) {
		
	$emails = $_POST['students_emails'];
	$f_names = $_POST['firstnames'];
	$l_names = $_POST['lastnames'];

	for ($i = 0; $i < count($emails); $i++) {
		$student = new Student();
		$student->setEmail($emails[$i]);
		$student->setFirstName($f_names[$i]);
		$student->setSurName($l_names[$i]);

			if (StudentDatabase::insertStudent($student)) {

				$record = new Record();
				$record->setStudentID(DatabaseConnector::getLastInsertedID());
				$record->setExamID($exam_id);
				$record->setIsSent(0);

				if(RecordDatabase::insertRecord($record)) {
					//echo '<br/>Wpisano rekord';
				} else {
					//echo '<br/>Blad przy wpisywaniu rekordu';
				}

			} else if (StudentDatabase::getStudentID($student) != null){

				$record = new Record();
				$record->setStudentID(StudentDatabase::getStudentID($student));
				$record->setExamID($exam_id);
				$record->setIsSent(0);

				if(RecordDatabase::insertRecord($record)) {
					//echo '<br/>Wpisano rekord';
				} else {
					//echo '<br/>Blad przy wpisywaniu rekordu';
				}

			} else {
				//echo '<br/>Blad przy wpisywaniu studenta';
			}

		}
	}
}

function addUnits($exam_id)
{
	if(isset($_POST['unlocked_units'])) {
		$units = $_POST['unlocked_units'];

		foreach ($units as $day => $day_units) {
			foreach ($day_units as $unit_index => $unit) {
				$exam_to_unit = new Exam();
				$exam_to_unit->setID($exam_id);

				$exam_unit = new ExamUnit();
				$exam_unit->setDay($day);
				$exam_unit->setTimeFrom($unit[0]);
				$exam_unit->setTimeTo($unit[1]);

				if($unit[2] == true) {
					$exam_unit->setState('unlocked');
				} else {
					$exam_unit->setState('locked');
				}

				if (ExamUnitDatabase::insertExamUnit($exam_to_unit, $exam_unit)) {
					//echo '<br/>Wpisano unit';
				} else {
					//echo '<br/>Blad przy wpisywaniu unit';
				}
			}

		}
	}
}

?>
