<?php
	include_once("../lib/Lib.php");

	if	(!isset($_SESSION['USER'])	||	$_SESSION['USER']	==	"")	{
		header('Location:	index.php'	);	
		}else{
			$user	=	UserDatabase::getUser($_GET['UserToRank']);
		}
	
		UserDatabase::updateUserRights($user, ($user->getRight()=="examiner") ? "administrator" : "examiner");

	header('Location: ../AdminUsers.php'); 
?>