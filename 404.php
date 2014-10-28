<?php
	include_once("lib/Lib.php");

	$title = "$appName - Błąd 404";
	include("html/Begin.php");
	$previous = $_SERVER['HTTP_REFERER'];
?>
<h1 style="text-align: center;">BŁĄD 404 - Nie udało się odnaleść rządanej strony</h1>
<hr />
<div style="text-align: center;">
	<img src="img/404.png">
</div>
<?php
	echo "<h3 style=\"text-align: center; margin-top: 10px;\">";
	if (isset($previous)) {
		echo '<a href="$previous">Powrót do poprzedniej strony</a>';
	} else {
		echo '<a href="index.php">Powrót do strony głównej</a>';
	}
	echo "</h3>";
	include("html/End.php");
?>