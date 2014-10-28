<?php
	include_once("../lib/Lib.php");
	include_once("Communicate.php");
	
	if (Settings::getDebug() == false) {
		Comunicate::printSiteDebugModeDisable();
		die();
	}
?>

<!DOCTYPE HTML>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	
	<body>
		<p><a href="index.php">Wróć do listy testów</a></p>
