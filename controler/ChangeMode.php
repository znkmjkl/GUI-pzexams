<?php
	include_once("../lib/Lib.php");

	$user=unserialize($_SESSION['USER']);
	if	(!isset($_SESSION['USER'])	||	$_SESSION['USER']	==	"" || $user->getRight()!="administrator")	{
		header('Location:	index.php'	);	
		}else{
			if(!isset($_SESSION['OPTION']) ||	$_SESSION['OPTION']	==	"" ){
				$_SESSION['OPTION']="exam";
				header('Location: ../UserSite.php'); 
			}else{
				$_SESSION['OPTION']="";
				header('Location: ../UserSite.php'); 
			}
		}

?>