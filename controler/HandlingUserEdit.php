<?php
    
    include_once("../lib/Lib.php");

    if (isset($_POST['submitButtonPassword']) == true) {
        
        $user = unserialize($_SESSION['USER']);
        $user = UserDatabase::getUser($user->getID());
        if( $user->getPassword() !=  sha1($_POST['passwd-old'])){// Check if present passord is correct
            $_SESSION['formErrorCode'] = 'passwordIncorrect';
        }else{
            if (UserDatabase::updateUserPassword($user, sha1($_POST['passwd']))) { 
                $_SESSION['formSuccessCode'] = 'passwordChanged';
                $user->setPassword($_POST['passwd']);
            }else {
			    $_SESSION['formErrorCode'] = 'databaseError';
		    }
        }
        header('Location: ../UserEdit.php' ); 
    }

    if (isset($_POST['submitButton']) == true) {
        $user = unserialize($_SESSION['USER']);
		$newUser = unserialize($_SESSION['USER']);
        $user2 = UserDatabase::getUser($user->getID());
        $user = UserDatabase::getUser($user->getID());
        
        if($_POST['nameEdit'] != $user->getFirstName()){
        if (UserDatabase::updateUserFirstName($user, $_POST['nameEdit'])) { 
            $_SESSION['formSuccessCode1'] = 'nameChanged';
			$newUser->setFirstName($_POST['nameEdit']);
        }else {
			$_SESSION['formErrorCode'] = 'databaseError';
		}}
        
        if($_POST['surnameEdit'] != $user->getSurname()){
        if (UserDatabase::updateUserSurname($user, $_POST['surnameEdit'])) { 
            $_SESSION['formSuccessCode2'] = 'surnameChanged';
			$newUser->setSurname($_POST['surnameEdit']);
        }else {
			$_SESSION['formErrorCode'] = 'databaseError';
		}}
        ( $_POST['genderEdit'] == "Kobieta" ) ? $user2->setGender("female") : $user2->setGender("male") ;
        if($user2->getGender() != $user->getGender()){
        if (UserDatabase::updateUserGender($user, $user2->getGender())) { 
            $_SESSION['formSuccessCode3'] = 'genderChanged';
        }else {
			$_SESSION['formErrorCode'] = 'databaseError';
		}}
		$_SESSION['USER'] = serialize($newUser);
		header('Location: ../UserEdit.php' ); 
    }
?>