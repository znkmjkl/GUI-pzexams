<?php

include_once("Exam.php");
include_once("ExamUnit.php");
include_once("DatabaseConnector.php");

final class ExamUnitDatabase
{    
	// Do testów
	static public function getExamUnitID($examU)
	{ 
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getID());

		$sql = "Select * from ExamUnits WHERE ExamID  = '" . $examID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		
		$row = $result->fetch_array(MYSQLI_NUM);
		return $row[0];
	}
	
	/*
	 * Zwraca listę ID examUnitsów dla danego egzaminu
	 */
	static public function getExamUnitIDList($examU)
	{ 
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getID());
		
		$sql = "Select * from ExamUnits WHERE ExamID  = '" . $examID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		
		$i = 0;
		while ($row = $result->fetch_array(MYSQLI_NUM)) {
			$examUnitID[$i] = $row[0]; 
			$i++;
		}
		return $examUnitID;
	}

	static public function getExamUnitIDListDay($examIDU,$dayU)
	{ 
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		$day = mysqli_real_escape_string(DatabaseConnector::getConnection(), $dayU);
		
		$sql = "Select * from ExamUnits WHERE ExamID = '" . $examID . "' AND Day = '" . $day . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		
		$i = 0;
		while ($row = $result->fetch_array(MYSQLI_NUM)) {
			$examUnitID[$i] = $row[0]; 
			$i++;
		}
		return $examUnitID;
	}
	
	static public function getExamUnit($idU){
		$id = mysqli_real_escape_string(DatabaseConnector::getConnection(), $idU);
		
		$sql = "SELECT * FROM ExamUnits WHERE ID = '" . $id . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$examUnit = null;
        
		if($row = $result->fetch_array(MYSQLI_ASSOC)){
			$examUnit = new ExamUnit(); 
			$examUnit->setID($row['ID']);
			$examUnit->setExamID($row['ExamID']);
			$examUnit->setDay($row['Day']);
			$examUnit->setTimeFrom($row['TimeFrom']);
			$examUnit->setTimeTo($row['TimeTo']);
			$examUnit->setState($row['State']);
		}
		return $examUnit;
	}
	
	static public function countExamUnits($examIDU)
	{
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		
		$sql = "SELECT COUNT(ExamID) AS UnitExamsCount FROM ExamUnits
		        WHERE ExamID = '" . $examID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		
		return $row[0];
	}
	
	static public function countLockedExamUnits($examIDU)
	{
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		
		$sql = "SELECT COUNT(ExamID) AS UnitExamsCount FROM ExamUnits
		        WHERE ExamID = '" . $examID . "' AND State = 'locked'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		
		return $row[0];
	}
	
	static public function countLockedExamUnitsByDay($examIDU, $dayU)
	{
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		$day = mysqli_real_escape_string(DatabaseConnector::getConnection(), $dayU);
		
		$sql = "SELECT COUNT(ExamID) AS UnitExamsCount FROM ExamUnits
		        WHERE ExamID = '" . $examID . "' AND Day = '" . $day . "' AND State = 'locked'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		
		return $row[0];
	}

	static public function getExamDays($examIDU){
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);

		$sql = "SELECT DISTINCT Day FROM ExamUnits WHERE ExamID = '" . $examID . "' ORDER BY day ASC";
		$result = DatabaseConnector::getConnection()->query($sql);
		$days = null;
		
		$i=0;
		while($row = $result->fetch_array(MYSQLI_NUM)){
			$days[$i]=$row[0];
			$i++;
		}
		
		return $days;
	}
	
	/*
	 * Zwraca liczbe niezakończonych egzaminów
	 */
	static public function countOpenExams($userIDU, $activatedU){
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		$activated = mysqli_real_escape_string(DatabaseConnector::getConnection(), $activatedU);
		
		date_default_timezone_set('Europe/Warsaw');
		$sql = "SELECT count(DISTINCT Exams.ID) FROM ExamUnits INNER JOIN Exams ON ExamUnits.ExamID = Exams.ID 
		        WHERE Exams.UserID = '" . $userID . "' AND Exams.Activated = '" . $activated . "' 
		        AND ExamUnits.Day > '" . date("Y/m/d") . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$examCount=0;
		
		
		if($result!=null){
			$row = $result->fetch_array(MYSQLI_NUM);
			$examCount=$row[0];
		}
		
		
		return $examCount;
	}

	static public function AdminCountOpenExams($activatedU){
		$activated = mysqli_real_escape_string(DatabaseConnector::getConnection(), $activatedU);
		
		date_default_timezone_set('Europe/Warsaw');
		$sql = "SELECT count(DISTINCT Exams.ID) FROM ExamUnits INNER JOIN Exams ON ExamUnits.ExamID = Exams.ID 
		        WHERE Exams.Activated = '" . $activated . "' AND ExamUnits.Day > '" . date("Y/m/d") . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$examCount=0;
		
		
		if($result!=null){
			$row = $result->fetch_array(MYSQLI_NUM);
			$examCount=$row[0];
		}
		
		
		return $examCount;
	}
	/*
	 *	usuwa dzień z wszystkimi exam unitami
	 */ 
	
	static public function deleteDayWithAllExamUnits($examIDU, $dayU) 
	{
		$day = mysqli_real_escape_string(DatabaseConnector::getConnection(), $dayU);
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		
		$sql = "UPDATE Records INNER JOIN ExamUnits ON Records.ExamUnitID = ExamUnits.ID 
		        SET Records.ExamUnitID = 'NULL' WHERE ExamUnits.ExamID  = '" . $examID . "' AND ExamUnits.Day  = '" . $day . "'";
				
		if(DatabaseConnector::getConnection()->query($sql) ? true : false){
			$sql = "DELETE FROM ExamUnits WHERE ExamID  = '" . $examID . "' AND Day = '" . $day . "'";
		}
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	}
	
	/*********************************************************************
	 ********************* Podstawowe funkcje sql ************************
	 *********************************************************************/
	 
	static public function insertExamUnit($examU, $examUnitU)
	{ 

		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getID());
		$examUnitDay = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getDay());
		$examUnitTimeFrom = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getTimeFrom());
		$examUnitTimeTo = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getTimeTo());
		$examUnitState = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getState());
						
		$values = "('"	. $examID . "','"
		                . $examUnitDay . "','" 
		                . $examUnitTimeFrom . "','"
						. $examUnitTimeTo . "','"
						. $examUnitState . "')";  
				
		$sql =  "INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) 
		         VALUES $values";
		
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	} 
    
	/*
	 * Edycja egzaminu (nazwa, czas trwania) w bazie danych, wraz ze sprawdzeniem czy dany egzaminator
	 * zamieścił egzamin i ma do tego uprawnienia
	 */ 
	static public function updateExamUnit($examUnitU)
	{
		$examUnitID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getID());
		$examUnitDay = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getDay());
		$examUnitTimeFrom = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getTimeFrom());
		$examUnitTimeTo = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getTimeTo());
		$examUnitState = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitU->getState());
		
		$sql = "UPDATE ExamUnits SET 
		        Day  = '" . $examUnitDay . "', 
		        TimeFrom = '" . $examUnitTimeFrom . "',
				TimeTo = '" . $examUnitTimeTo . "',
				State = '" . $examUnitState . "'
		        WHERE ID = '" . $examUnitID . "'";
					
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	} 
    
	/*
	 * Usunięcie egzaminu z bazy danych, wraz ze sprawdzeniem czy dany egzaminator
	 * zamieścił egzamin i ma do tego uprawnienia
	 */ 
	static public function deleteExamUnit($examUnitIDU)
	{
		$examUnitID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitIDU);
		
		$sql = "UPDATE Records SET ExamUnitID = 'NULL' WHERE ExamUnitID  = '" . $examUnitID . "'";
		if(DatabaseConnector::getConnection()->query($sql) ? true : false){
			$sql = "Delete from ExamUnits WHERE ID  = '" . $examUnitID . "'";
		}
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	}
    
	static public function deleteExamUnit2($examIDU,$dayU,$timeFromU)
	{
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		$day = mysqli_real_escape_string(DatabaseConnector::getConnection(), $dayU);
		$timeFrom = mysqli_real_escape_string(DatabaseConnector::getConnection(), $timeFromU);
		
		$sql = "UPDATE Records INNER JOIN ExamUnits ON Records.ExamUnitID = ExamUnits.ID 
				SET Records.ExamUnitID = 'NULL'
				WHERE ExamUnits.ExamID  = '" . $examID . "' AND 
				      ExamUnits.Day  = '" . $day . "' AND
				      ExamUnits.TimeFrom  = '" . $timeFrom . "'";
		
		if(DatabaseConnector::getConnection()->query($sql) ? true : false){
			$sql = "Delete from ExamUnits WHERE ExamID  = '" . $examID . "' AND 
		                                        Day = '" . $day . "' AND 
		                                        TimeFrom = '" . $timeFrom . "'";
		}
		
		
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	}
	
	// Nie pozwalamy na utworzenie obiektu - Jeżeli zrozumiałeś design to nigdy nie zmienisz tego konstruktora na publiczny ;)
	private function __construct() { }
}

?>
