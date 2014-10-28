<?php
    
    include_once("../lib/Lib.php");

    if (isset($_POST['submitButtonPassword']) == true){
		$user = UserDatabase::getUser($_SESSION['IDEdit']);
            if (UserDatabase::updateUserPassword($user, sha1($_POST['passwd']))) { 
                $_SESSION['formSuccessCode'] = 'passwordChanged';
            }else {
			    $_SESSION['formErrorCode'] = 'databaseError';
		    }
        header('Location: ../AdminUserEdit.php?UserToEdit=' . $user->getID() ); 
    }

    if (isset($_POST['submitButton']) == true) {
         $user = UserDatabase::getUser(unserialize($_SESSION['IDEdit']));
        
        if($_POST['nameEdit'] != $user->getFirstName()){
        if (UserDatabase::updateUserFirstName($user, $_POST['nameEdit'])) { 
            $_SESSION['formSuccessCode1'] = 'nameChanged';
        }else {
			$_SESSION['formErrorCode'] = 'databaseError';
		}}
        
        if($_POST['surnameEdit'] != $user->getSurname()){
        if (UserDatabase::updateUserSurname($user, $_POST['surnameEdit'])) { 
            $_SESSION['formSuccessCode2'] = 'surnameChanged';
        }else {
			$_SESSION['formErrorCode'] = 'databaseError';
		}}
        
        if((( $_POST['genderEdit'] == "Kobieta" ) ? "female" : "male") != $user->getGender()){
        if (UserDatabase::updateUserGender($user, (( $_POST['genderEdit'] == "Kobieta" ) ? "female" : "male"))) { 
            $_SESSION['formSuccessCode3'] = 'genderChanged';
        }else {
			$_SESSION['formErrorCode'] = 'databaseError';
		}}
		header('Location: ../AdminUserEdit.php?UserToEdit=' . $user->getID() ); 
    }
?>