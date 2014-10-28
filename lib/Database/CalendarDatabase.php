<?php
 
include_once("Calendar.php");
include_once("DatabaseConnector.php");

final class CalendarDatabase
{
	/*
	 * Zwraca instancje Calendar dla egzaminu o zadanym ID
	 */
	static public function getCalendarForExamId($id) {
		$sql = "SELECT * FROM Exams  JOIN ExamUnits ON ExamUnits.ExamID = Exams.ID WHERE Exams.ID = '" . $id . 
				"' ORDER BY Day , TimeFrom";
		$result = DatabaseConnector::getConnection()->query($sql);
		$exam = new Exam();
		$examUnit = null;         
		$row = $result->fetch_assoc();
		$exam->setName($row['Name']);
	    $exam->setDuration($row['Duration']);  
		$calendar = new BasicCalendar($exam);
		// przesun wskaźnik na początek 
		$row = $result->data_seek(0);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$examUnit = new ExtendedExamUnit(); 
			$studentNameArray = CalendarDatabase::getPersonEnroledForDayTime($id , $row['Day'] , $row['TimeFrom']) ;
			if ( $studentNameArray != NULL  ) { 
				$examUnit->setStudentName( $studentNameArray['FirstName'] ) ;  
				$examUnit->setStudentSurname ( $studentNameArray['Surname'] ) ;
			} else { 
				$examUnit->setStudentName( "null" ) ;
				$examUnit->setStudentSurname("null" ) ; 
			} 
			$examUnit->setDay($row['Day']);
			$examUnit->setTimeFrom($row['TimeFrom']);
			$examUnit->setTimeTo($row['TimeTo']);
			$calendar->addExamUnit($examUnit);
		}
		return $calendar;
	}  
 	
 	static private function getPersonEnroledForDayTime ( $examId , $day , $timeFrom ) {
		// statement for test purpose 
		// SELECT S.Surname , S.FirstName , E.Name , E.Duration , U.Day ,  U.TimeFrom , U.TimeTo  FROM Students as S JOIN Records as R ON S.ID = R.StudentID JOIN Exams as E ON E.ID = R.ExamID JOIN ExamUnits as U ON R.ExamUnitID = U.ID WHERE E.ID = 7 AND U.Day='2015-06-18' AND U.TimeFrom='08:00:00' ;
		$sql = "SELECT S.Surname , S.FirstName FROM Students as S " . 
				"JOIN Records as R ON S.ID = R.StudentID " .
				"JOIN Exams as E ON E.ID = R.ExamID " .
				"JOIN ExamUnits as U ON R.ExamUnitID = U.ID " . 
				"WHERE E.ID = '" . $examId . "' AND U.Day= ' " . $day . "' AND U.TimeFrom='" . $timeFrom . "'" ; 
		$result = DatabaseConnector::getConnection()->query($sql); 
		$row = $result->fetch_assoc() ; 
		if ( $row == NULL ) 
			return NULL ; 
		return array ( 'FirstName'=> $row['FirstName'] , 'Surname'=> $row['Surname']  ) ;
 	} 
 
 	
	private function __construct() { }
} 

// only test purpose 
//echo "<h1> Calendar Database Test is done . </h1> "; 
//CalendarDatabase::getCalendarForExamId(7)->printCalendar(); 
//var_dump (  CalendarDatabase::getPersonEnroledForDayTime(7 , '2015-06-18' , '08:00:00' ));
  
?>
