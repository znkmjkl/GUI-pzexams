<?php
	include_once("Record.php");
	include_once("DatabaseConnector.php");
	
 	final class RecordDatabase
 	{
	
		/* 
		 * Zwraca ID Recordu jezeli jest przypisany, lub NULL jeżeli nie jest przypisany
		 */
		static public function getRecordID($examIDU, $studentIDU)
		{ 
			$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
			$studentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentIDU);
			
			$sql = "Select * from Records WHERE ExamID = '" . $examID . "' AND StudentID  = '" . $studentID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$ID = null;
	
			if($row = $result->fetch_array(MYSQLI_NUM))
				$ID = $row[0]; 
	
			return $ID;
		}

		static public function getRecordFromUnit($examUnitIDU)
		{
			$examUnitID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitIDU);
			
			$sql = "Select * from Records WHERE ExamUnitID  = '" . $examUnitID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$record = null;
        
			if($row = $result->fetch_array(MYSQLI_ASSOC)){
				$record = new Record(); 
				$record->setID($row['ID']);
				$record->setStudentID($row['StudentID']);
				$record->setExamID($row['ExamID']);
				$record->setExamUnitID($row['ExamUnitID']);
			}
			
			return $record;
		}
		
		static public function getRecord($recordIDU)
		{
			$recordID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordIDU);
			
			$sql = "Select * from Records WHERE ID  = '" . $recordID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$record = null;
        
			if($row = $result->fetch_array(MYSQLI_ASSOC)){
				$record = new Record(); 
				$record->setID($row['ID']);
				$record->setStudentID($row['StudentID']);
				$record->setExamID($row['ExamID']);
				$record->setExamUnitID($row['ExamUnitID']);
				$record->setIsSent($row['MessageSent']);
			}
			
			return $record;
		}

		/*
		 * Zwraca listę ID Examinow przypisanych do studenta
		 */
		static public function getExamIDList($studentIDU){
		
			$studentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentIDU);

			$sql = "Select * from Records WHERE StudentID  = '" . $studentID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$examID = null;
			
			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$examID[$i] = $row['ExamID']; 
				$i++;
			}
			return $examID;
		}

		/*
		 * Zwraca listę ID Examinow przypisanych do studenta i posiadających ExamUnit
		 */
		static public function getAssignedExamIDList($studentID){
			$sql = "Select * from Records WHERE StudentID  = '" . $studentID . "' AND ExamUnitID IS NOT NULL AND NOT ExamUnitID = 0";
			$result = DatabaseConnector::getConnection()->query($sql);
			$examID = null;
			
			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$examID[$i] = $row['ExamID']; 
				$i++;
			}
			return $examID;
		}
		
		/*
		 * Zwraca listę ID Studentów przypisanych do egzaminów
		 */
		static public function getStudentIDList($examIDU){
			
			$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
		
			$sql = "Select * from Records WHERE ExamID  = '" . $examID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$studentID = null;
			
			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$studentID[$i] = $row['StudentID']; 
				$i++;
			}
			return $studentID;
		}
		
		/* 
		 * Zwraca ID ExamUnitsów i Studentów jezeli jest przypisany, lub NULL jeżeli nie jest przypisany
		 */
		static public function getExamUnitIDStudentIDList($examIDU){
		
			$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);

			$sql = "Select * from Records WHERE ExamID = '" . $examID . "' AND StudentID  != 'NULL'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$records = null;
			
			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$records[$i]['ExamUnitID'] = $row['ExamUnitID']; 
				$records[$i]['StudentID'] = $row['StudentID'];
				$i++;	
			}

			return $records;
		}
		
		/* 
		 * Zwraca ID ExamUnitsa jezeli jest przypisany, lub NULL jeżeli nie jest przypisany
		 */
		static public function getExamUnitID($examIDU,$studentIDU){
		
			$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
			$studentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentIDU);

			$sql = "Select * from Records WHERE ExamID = '" . $examID . "' AND StudentID  = '" . $studentID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$examUnitID = null;
			
			if($row = $result->fetch_array(MYSQLI_ASSOC))
				$examUnitID = $row['ExamUnitID']; 

			return $examUnitID;
		}
		
		static public function countAssignedExamUnits($examIDU)
		{
		
			$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);

			$sql = "SELECT COUNT(ExamID) AS UnitExamsCount FROM Records
			        WHERE ExamID = '" . $examID . "' AND ExamUnitID != 'NULL'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$row = $result->fetch_array(MYSQLI_NUM);
			
			return $row[0];
		}
		
		/*
		 * Zwraca liczbe Studentów Egzaminatora
		 */
		static public function countStudentsByExam($examIDU){
		
			$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);

			$sql = "SELECT count(StudentID) FROM Records 
			        WHERE ExamID = '" . $examID . "'";
					
			$result = DatabaseConnector::getConnection()->query($sql);
			$studentCount=0;
			
			if($result!=null){
				$row = $result->fetch_array(MYSQLI_NUM);
				$studentCount=$row[0];
			}	
			
			return $studentCount;
		}
		
		/*
		 * Zwraca liczbe Studentów Egzaminatora
		 */
		static public function countUserStudents($userIDU){
		
			$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);

			$sql = "SELECT count(Exams.ID) FROM Records INNER JOIN Exams ON Records.ExamID = Exams.ID 
			        WHERE Exams.UserID = '" . $userID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$examCount=0;
			
			if($result!=null){
				$row = $result->fetch_array(MYSQLI_NUM);
				$examCount=$row[0];
			}
			
			
			return $examCount;
		}
		
		static public function adminCountUserStudents(){
			$sql = "SELECT count(Exams.ID) FROM Records INNER JOIN Exams ON Records.ExamID = Exams.ID";
			$result = DatabaseConnector::getConnection()->query($sql);
			$examCount=0;
			
			if($result!=null){
				$row = $result->fetch_array(MYSQLI_NUM);
				$examCount=$row[0];
			}
			
			
			return $examCount;
		}
		
		/*
		 * Zwraca liczbe Studentów Egzaminatora zapisanych na egzaminy
		 */
		static public function countUserStudentsSingedToExams($userIDU){
		
			$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);

			$sql = "SELECT count(Exams.ID) FROM Records INNER JOIN Exams ON Records.ExamID = Exams.ID 
			        WHERE Exams.UserID = '" . $userID . "' AND Records.ExamUnitID != 'NULL'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$examCount=0;
			
			if($result!=null){
				$row = $result->fetch_array(MYSQLI_NUM);
				$examCount=$row[0];
			}
			
			
			return $examCount;
		}
		
		static public function adminCountUserStudentsSingedToExams(){
			$sql = "SELECT count(DISTINCT StudentID) FROM Records WHERE ExamUnitID != 'NULL'";
			$result = DatabaseConnector::getConnection()->query($sql);
			$examCount=0;
			
			if($result!=null){
				$row = $result->fetch_array(MYSQLI_NUM);
				$examCount=$row[0];
			}
			
			
			return $examCount;
		}
		/*
		 * 
		 */
		static public function messageSent($studentIDU, $examIDU)
		{
			$studentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $studentIDU);
			$examID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examIDU);
			
			$sql = "Select * from Records WHERE ExamID  = '" . $examID . "' AND StudentID = '" . $studentID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			if ($result->num_rows == 0) { 
				return false;
			}
			
			$sql = "UPDATE Records SET 
					MessageSent = '" . 1 . "' 
					WHERE ExamID = '" . $examID . "' AND StudentID = '" . $studentID . "'";
			
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		}
		
		static public function recordTransaction($recordIDU,$examUnitIDU)
		{
			$transaction = DatabaseConnector::getConnection();
			
			$recordID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordIDU);
			$examUnitID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $examUnitIDU);
			
			try{			
				$transaction->autocommit(false);
				$sql = "Select * from Records WHERE ID  = '" . $recordID . "'";
				$result = $transaction->query($sql);
				if ($result->num_rows == 0) { 
					throw new Exception('There is no such Record');
				}
				
				$row = $result->fetch_array(MYSQLI_ASSOC);
				if($row['ExamUnitID']!=0){
					throw new Exception('Overwriting not allowed');
				}
				
				$sql = "Select * from Records WHERE ExamUnitID  = '" . $examUnitID . "'";
				$result = $transaction->query($sql);
				if ($result->num_rows > 0) { 
					throw new Exception('Already taken');
				}
				
				$sql = "UPDATE Records SET 
						ExamUnitID = '" . $examUnitID . "'
						WHERE ID = '" . $recordID . "'";
					
				if($transaction->query($sql)? false:true){
					throw new Exception('Something failed while update');
				}
				
				$sql = "Select * from Records WHERE ID  = '" . $recordID . "'";
				$result = $transaction->query($sql);				
				$row = $result->fetch_array(MYSQLI_ASSOC);
				if($row['ExamUnitID']!=$examUnitID){
					throw new Exception('Overwriting not allowed');
				}
			
				$transaction->commit();
				
			}catch(Exception $e){
				$transaction->rollback();
				return false;
			}
			$transaction->autocommit(true);
			return true;
		} 
		
		/*********************************************************************
		 ********************* Podstawowe funkcje sql ************************
		 *********************************************************************/
		 
		static public function insertRecord($recordU)
		{
			$recordStudentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordU->getStudentID());
			$recordExamID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordU->getExamID());
			
			$values = "('"	. $recordStudentID . "','"
			                . $recordExamID . "')";
			
			$sql =  "INSERT INTO Records (StudentID, ExamID) VALUES $values";
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		} 
		
		static public function updateRecord($recordU)
		{
			$recordID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordU->getID());
			$recordStudentID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordU->getStudentID());
			$recordExamID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordU->getExamID());
			$recordExamUnitID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordU->getExamUnitID());
			
			$sql = "Select * from Records WHERE ID  = '" . $recordID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			if ($result->num_rows == 0) { 
				return false;
			}

			$sql = "UPDATE Records SET 
			        StudentID  = '" . $recordStudentID . "', 
			        ExamID = '" . $recordExamID . "', 
			        ExamUnitID = '" . $recordExamUnitID . "'
			        WHERE ID = '" . $recordID . "'";
				
			
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		} 

		static public function deleteRecord($recordU)
		{
			$recordID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $recordU->getID());
			
			$sql = "Select * from Records WHERE ID  = '" . $recordID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			if ($result->num_rows == 0) { 
				return false;
			}
			
			$sql = "Delete from Records WHERE ID  = '" . $recordID . "'";
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		}
		
		private function __construct() { }
	}
?>