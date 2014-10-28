<?php
	final class Comunicate { 
		static function printSiteDebugModeDisable() {
			echo '
			<!DOCTYPE HTML>
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				</head>
				<body>
					<p>W chwili obecnej tryb debugowania apliakcji jest wyłączony.</p>
					<p><a href="../index.php">Powrót do strony głównej</a></p>
				</body>
			</html>
			';
		}
		
		private function __construct() { }
	}
?>
