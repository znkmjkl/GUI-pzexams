<?php
	session_destroy();
	session_start();
	$_SESSION['USER'] = "";
	header('Location: ../index.php');
?>
