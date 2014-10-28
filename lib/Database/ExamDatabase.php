<?php

include_once("User.php");
include_once("Exam.php");
include_once("DatabaseConnector.php");

final class ExamDatabase
{
	/*
	 * Sprawdza czy egzamin o danym ID istnieje w bazie danych.
	 */
	static public function checkExamID($IDU)
	{	
		$ID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $IDU);
		
		$sql = "Select * from Exams where ID = '" . $ID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		
		if ($result->num_rows == 0) { 
			return false;
		}
		
		return true;
	}
    
	/*
	 * Sprawdza czy egzamin o danym ID istnieje w bazie danych.
	 */
	static public function checkIfUserHasExam($userIDU, $examIDU)
	{	
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		
		$sql = "Select * from Exams where ID = '" . $examID . "' AND UserID = '" . $userID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		
		if ($result->num_rows == 0) { 
			return false;
		}
		
		return true;
	}
	
	/*
	 * Sprawdza czy egzamin o danej nazwie istnieje w bazie danych.
	 */
	static public function checkExamName($nameU)
	{
		$name = mysqli_real_escape_string(DatabaseConnector::getConnection(), $nameU);
		
		$sql = "Select * from Exams where Name = '" . $name . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		
		if ($result->num_rows == 0) { 
			return false;
		}
		
		return true;
	}
	
	/*
	 * Zwraca exam o danym ID
	 */
	static public function getExam($idU)
	{
		$id = mysqli_real_escape_string(DatabaseConnector::getConnection(), $idU);
		
		$sql = "SELECT * FROM Exams WHERE ID = '" . $id . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$exam = null;
        
		if($row = $result->fetch_array(MYSQLI_ASSOC)){
			$exam = new Exam(); 
			$exam->setID($row['ID']);
			$exam->setUserID($row['UserID']);
			$exam->setName($row['Name']);
			$exam->setDuration($row['Duration']);
			$exam->setActivated($row['Activated']);
			$exam->setEmailsPosted($row['EmailsPosted']);
		}
		return $exam;
	}  
	/*
	 * Zwraca listę egzaminów w tabeli danego usera
	 */
	static public function getExamList($userIDU)
	{
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		
		$sql = "SELECT * FROM Exams WHERE UserID = '" . $userID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$exams = null;
        
		$i = 0;
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$exams[$i] = new Exam(); 
			$exams[$i]->setID($row['ID']);
			$exams[$i]->setUserID($row['UserID']);
			$exams[$i]->setName($row['Name']);
			$exams[$i]->setDuration($row['Duration']);
			$exams[$i]->setActivated($row['Activated']);
			$exams[$i]->setEmailsPosted($row['EmailsPosted']);
			$i++;
        }
        
		return $exams;
	} 
	
	static public function getAllExams()
	{
            $sql = "SELECT * FROM Exams";
            $result = DatabaseConnector::getConnection()->query($sql);
            if (!$result) {
                return null;
            }

			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_NUM)) {
				$exam = new Exam(); 
				$exam->setID($row[0]);
				$exam->setUserID($row[1]);
				$exam->setName($row[2]);
				$exam->setActivated($row[4]);
				$exams[$i] = $exam; 
				$i++;
			}
		return $exams;
	} 
    
	/*
	 * Zwraca ilość egzaminów danego usera
	 */
	static public function countExams($userIDU)
	{
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		
		$sql = "SELECT COUNT(UserID) AS UserExams FROM Exams
		        WHERE UserID = '" . $userID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		
		return $row[0];
	}
	
	/*
	 * Funkcja do aktywacji egzaminu 
	 */
	static public function activateExam($userIDU, $examIDU)
	{	
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		
		$sql = "Select * from Exams WHERE ID  = '" . $examID . "' AND UserID = '" . $userID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		if ($result->num_rows == 0) { 
			return false;
		}
		
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$status = $row['Activated'];
		
		if($status){
			$status = 0;
		} else {
			$status = 1;			
		}	
		
		$sql = "UPDATE Exams 
		        SET Activated = '" . $status . "' 
		        WHERE ID = '" . $examID . "'";
						
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	}
	
	static public function PostEmail($userIDU, $examIDU)
	{
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		
		$sql = "Select * from Exams WHERE ID  = '" . $examID . "' AND UserID = '" . $userID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		if ($result->num_rows == 0) { 
			return false;
		}
		
		$sql = "UPDATE Exams SET 
		        EmailsPosted = '" . 1 . "' 
		        WHERE ID = '" . $examID . "'";
		
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	}
    
	static public function adminCountActivated($activatedU)
	{		
		$activated = mysqli_real_escape_string(DatabaseConnector::getConnection(), $activatedU);
		$sql = "SELECT count(ID) FROM Exams WHERE Activated = '" . $activated . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$examCount=0;

		if($result!=null){
			$row = $result->fetch_array(MYSQLI_NUM);
			$examCount=$row[0];
		}
		
		
		return $examCount;
	}
	
	static public function adminCountExams()
	{		
		$sql = "Select COUNT(ID) From Exams";
		$result = DatabaseConnector::getConnection()->query($sql);
		$examCount=0;

		if($result!=null){
			$row = $result->fetch_array(MYSQLI_NUM);
			$examCount=$row[0];
		}
		
		
		return $examCount;
	}
	
	
	/*********************************************************************
	 ********************* Podstawowe funkcje sql ************************
	 *********************************************************************/
		 
	static public function insertExam($userIDU, $examU)
	{ 
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		$examName = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getName());
		$examDuration = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getDuration());
		$examActivated = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getActivated());
		$examEmailsPosted = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getEmailsPosted());
		
		$values = "('"  . $userID . "','"
		                . $examName . "','" 
		                . $examDuration . "','"
		                . $examActivated . "','"  
		                . $examEmailsPosted . "')";
				
		$sql =  "INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted)" 
		        .  "VALUES $values";
		
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	} 
    
	/*
	 * Edycja egzaminu (nazwa, czas trwania) w bazie danych, wraz ze sprawdzeniem czy dany egzaminator
	 * zamieścił egzamin i ma do tego uprawnienia
	 */ 
	static public function updateExam($userIDU, $examU)
	{	
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		$examName = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getName());
		$examDuration = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getDuration());
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examU->getID());

		
		$sql = "Select * from Exams WHERE ID  = '" . $examID . "' AND UserID = '" . $userID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		if ($result->num_rows == 0) { 
			return false;
		}
		
		$sql = "UPDATE Exams SET 
		        Name  = '" . $examName . "', 
		        Duration = '" . $examDuration . "' 
		        WHERE ID = '" . $examID . "'";
					
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	} 
    
	/*
	 * Usunięcie egzaminu z bazy danych, wraz ze sprawdzeniem czy dany egzaminator
	 * zamieścił egzamin i ma do tego uprawnienia
	 */ 
	static public function deleteExam($userIDU, $examIDU)
	{
		$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
		$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		
		$sql = "Select * from Exams WHERE ID  = '" . $examID . "' AND UserID = '" . $userID . "'";
		$result = DatabaseConnector::getConnection()->query($sql);
		if ($result->num_rows == 0) { 
			return false;
		}
		
		$sql = "Delete from Exams WHERE ID  = '" . $examID . "'";
		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	}
    
	// Nie pozwalamy na utworzenie obiektu - Jeżeli zrozumiałeś design to nigdy nie zmienisz tego konstruktora na publiczny ;)
	private function __construct() { }
}

?>
