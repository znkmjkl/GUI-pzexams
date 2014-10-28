<?php
	include_once("../../lib/Lib.php");
	include_once("../../lib/Database/CalendarDatabase.php");
	include_once("../../lib/Database/Calendar.php");
	header("content-type:application/json");
	
	$dataSavedInDB = array ('status' => 'dataSavedProperly') ; 
	$dataNotSavedInDB = array ('status' => 'dataSavedUnproperly' ) ;  
	
	$jsonExamUnitBlock = json_decode(file_get_contents('php://input') , true );
	//var_dump ( $jsonExamUnitBlock ); 
	if ( $jsonExamUnitBlock != null  ) { 
		if ( $jsonExamUnitBlock['examUnitsBlock'] != null ) {
			for ($idx=0; $idx < count ( $jsonExamUnitBlock['examUnitsBlock'] ) ; $idx++) {
				$exam = new Exam(); 
				$exam->setID( $jsonExamUnitBlock['examID']);
				$examUnit = new ExamUnit(); 
				//echo ( $idx ." ". $jsonExamUnitBlock['examUnitsBlock'][$idx]['timeFrom'] ."<br />") ; 
				$examUnit->setTimeFrom($jsonExamUnitBlock['examUnitsBlock'][$idx]['timeFrom']);
				$examUnit->setTimeTo($jsonExamUnitBlock['examUnitsBlock'][$idx]['timeTo']);
				$examUnit->setDay($jsonExamUnitBlock['examUnitsBlock'][$idx]['day']);
				// stan unlocked - nikt nie miał sie szansy zapisać 
				$examUnit->setState("unlocked");   
				ExamUnitDatabase::insertExamUnit($exam , $examUnit);
			} 
			echo json_encode($dataSavedInDB);
		} else { 
			echo json_encode($dataNotSavedInDB);
		} 			 		
	} else { 
		if (isset($_POST['examID']) && 
			isset($_POST['requestType'])
			) {
				switch ($_POST['requestType']) {
				case 'addExamUnit':
					if (isset($_POST['timeTo']) && isset($_POST['timeFrom']) && isset($_POST['day'])) { 
						$exam = new Exam(); 
						$exam->setID($_POST['examID']);
						$examUnit = new ExamUnit(); 
						$examUnit->setTimeFrom($_POST['timeFrom']);
						$examUnit->setTimeTo($_POST['timeTo']);
						$examUnit->setDay($_POST['day']);
						// stan unlocked - nikt nie miał sie szansy zapisać 
						$examUnit->setState("unlocked");   
						ExamUnitDatabase::insertExamUnit($exam , $examUnit);
						echo json_encode($dataSavedInDB);
					} else { 
						echo json_encode($dataNotSavedInDB);
					} 			 		
					break;
				case 'removeExamUnit': 
					if (isset($_POST['timeFrom']) && isset($_POST['day'])) { 
						ExamUnitDatabase::deleteExamUnit2($_POST['examID'],$_POST['day'],$_POST['timeFrom']);
						echo json_encode($dataSavedInDB);
					} else { 
						echo json_encode($dataNotSavedInDB);
					} 
					break;
				case 'removeDay': 
					if (isset($_POST['day'])) { 
						ExamUnitDatabase::deleteDayWithAllExamUnits($_POST['examID'],$_POST['day']);
						echo json_encode($dataSavedInDB);
					} else { 
						echo json_encode($dataNotSavedInDB);
					} 
					break; 
				default : 
					echo json_encode($dataNotSavedInDB);						
			}
			if ( CalendarDatabase::getCalendarForExamId($_POST['examID'])) {
			
			}  
		} else { 
			echo json_encode($dataNotSavedInDB); 
		}
	}
?>
