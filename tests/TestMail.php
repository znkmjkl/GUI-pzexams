<?php
	include_once('../lib/Lib.php');

	include("TestBegin.php");
	
	// Przed przetestowaniem należy w tym miejscu zmienić adres email do, którego będziemy wysyłać naszą wiadomość testową!
	$messageBody = "Witaj!\nTo jest wiadomość testowa serwisu PZ-Exams. Nie odpowiadaj na nią!.\n\nPozdrawiamy,\nZespół PZ-Exams\n";
	if (mailer('-', 'pz.exams@gmail.com', 'PZ-Exams', 'Wiadomość testowa - PZ-Exams', "$messageBody", true)) {
		echo "<p>Email został poprawnie wysłany!</p>";
	} else {
		echo "<p>Nie udało się wysłać emaila!</p>";
	}
	
	include_once('TestEnd.php');
?>
