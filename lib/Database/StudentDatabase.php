<?php
	
	include_once("Student.php");
	include_once("DatabaseConnector.php");
	
 	final class StudentDatabase
 	{
	
		// Do testów
		static public function getStudentID($studentU)
		{ 
			$studentEmail = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentU->getEmail());
			
			$sql = "Select * from Students WHERE Email  = '" . $studentEmail . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
		
			$row = $result->fetch_array(MYSQLI_NUM);
			return $row[0];
		}
		
		static public function getStudentByCode($codeU)
		{ 
			$code = mysqli_real_escape_string(DatabaseConnector::getConnection(), $codeU);
			
			$sql = "Select * from Students WHERE Code  = '" . $code . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			
			$student = new Student();
			$student->setID($row['ID']);
			$student->setEmail($row['Email']);
			$student->setCode($row['Code']);
			$student->setFirstName($row['FirstName']);
			$student->setSurName($row['Surname']);
			
			return $student;		
		}

		static public function getAllStudents()
        {
            $sql = "SELECT * FROM Students";
            $result = DatabaseConnector::getConnection()->query($sql);
            if (!$result) {
                return null;
            }

			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_NUM)) {
				$resultUser = new Student(); 
				$resultUser->setID($row[0]);
				$resultUser->setEmail($row[1]);
				$resultUser->setFirstName($row[3]);
				$resultUser->setSurName($row[4]);
				$users[$i] = $resultUser; 
				$i++;
			}
			return $users;
        }
	
		static public function getStudentByID($idU)
		{ 
			$id = mysqli_real_escape_string(DatabaseConnector::getConnection(), $idU);
			
			$sql = "Select * from Students WHERE ID  = '" . $id . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			
			$student = new Student();
			$student->setID($row['ID']);
			$student->setEmail($row['Email']);
			$student->setCode($row['Code']);
			$student->setFirstName($row['FirstName']);
			$student->setSurName($row['Surname']);
			
			return $student;
		}
		
		static public function addStudentCode($studentIDU, $codeU)
		{ 
			$studentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentIDU);
			$code = mysqli_real_escape_string(DatabaseConnector::getConnection(), $codeU);
			
			$sql = "Select * from Students WHERE ID  = '" . $studentID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			if ($result->num_rows == 0) { 
				return false;
			}
			$row=$result->fetch_array(MYSQLI_ASSOC);
			
			if(!$row['Code']==NULL){
				return false;
			}
		
			$sql = "UPDATE Students SET 
			        Code  = '" . $code . "'
			        WHERE ID = '" . $studentID . "'";
			
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		}
		
		static public function insertStudent($studentU)
		{
			$studentEmail = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentU->getEmail());
			$studentFirstName = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentU->getFirstName());
			$studentSurName = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentU->getSurName());
			$code = md5($studentEmail . time());
			
			$sql =  "SELECT * FROM Students WHERE Email = '" . $studentEmail . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			if($result->num_rows!=0){
				return false;
			}
			
			$sql =  "SELECT * FROM Students WHERE Code = '" . $code . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			
			while($result->num_rows!=0){
				$code = md5($studentEmail . time());
				$sql =  "SELECT * FROM Students WHERE Code = '" . $code . "'";
				$result = DatabaseConnector::getConnection()->query($sql);
			}
			
			$values = "('"	. $studentEmail . "','"
			                . $code . "','"
			                . $studentFirstName . "','"
			                . $studentSurName . "')";
			
			$sql =  "INSERT INTO Students (Email, Code, FirstName, Surname) VALUES $values";
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		} 
		
		static public function updateStudent($studentU)
		{
			$studentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentU->getID());
			$studentEmail = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentU->getEmail());
			$studentFirstName = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentU->getFirstName());
			$studentSurName = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentU->getSurName());
			
			$sql = "Select * from Students WHERE ID  = '" . $studentID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			if ($result->num_rows == 0) { 
				return false;
			}
		
			$sql = "UPDATE Students SET 
			        Email  = '" . $studentEmail . "', 
			        FirstName = '" . $studentFirstName . "', 
			        Surname = '" . $studentSurName . "'
			        WHERE ID = '" . $studentID . "'";
			
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		} 
    
		/*
		 * Usunięcie egzaminu z bazy danych, wraz ze sprawdzeniem czy dany egzaminator
		 * zamieścił egzamin i ma do tego uprawnienia
		 */ 
		static public function deleteStudent($studentIDU)
		{
			$studentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentIDU);
			
			$sql = "Select * from Students WHERE ID  = '" . $studentID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			if ($result->num_rows == 0) { 
				return false;
			}
		
			$sql = "Delete from Students WHERE ID  = '" . $studentID . "'";
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		}
		
		private function __construct() { }
	}
?>