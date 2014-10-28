<?php
	include_once("../../lib/Lib.php");
	header("content-type:application/json");
	$emailExistJSON = array( 'status' => 'dataRecived' , 
					'email' => 'existsInDB' ) ;
	
	$emailNotInDBJSON = array( 'status' => 'dataRecived' , 
					'email' => 'notInDB' ) ;	
				   
				   
	//$req = array( 'status' => $_POST['email'] , 
	//				   'email' => 'notInDB' ) ;					   
	//echo json_encode($req) ;
				   
	if (isset($_POST['email'])) {
		$basicUser = new BasicUser();
		$basicUser->setEmail($_POST['email']) ;  
		if (UserDatabase::checkEmail($basicUser)) {
			echo json_encode($emailExistJSON) ;
		} else { 
			echo json_encode($emailNotInDBJSON) ; 
		} 
	} else { 
		echo json_encode($emailNotInDBJSON) ; 
	}
	
?>
