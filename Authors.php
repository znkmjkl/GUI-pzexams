<?php
	include("lib/Lib.php");
	
	$title	=	"$appName - Autorzy projektu";
	include("html/Begin.php");
?>

<div class="container">
	<div style="text-align: center">
		<img src="img/logo_button.png">
		<p style="margin-top: 5px;">Projekt realizowany w ramach przedmiotu "Programowanie zespołowe" na Uniwersytecie Jagielońskim.</p>
	</div>
	<div id="author" style="color:#ACACAC; text-shadow: 1px 1px #838996;">Product Owner</div>
	<div id="creatorFirst">Zbigniew Rębacz</div>
	<div id="author" style="color:#ACACAC; text-shadow: 1px 1px #838996;">Scrum Master</div>
	<div id="creatorFirst">Michał Pachel</div>
	<div id="author" style="color:#ACACAC; text-shadow: 1px 1px #838996;">Development Team</div>
	<div id="creatorFirst">Arkadiusz Koszczan</div>
	<div id="creator">Michał Szura</div>
	<div id="creator">Michał Gawryluk</div>
	<div id="creator">Mateusz Jancarz</div>
	<div id="creator">Konrad Welc</div>
</div>

<?php	include	("html/End.php");	?>