<!DOCTYPE HTML>

<html>
	<head>
		<?php
			if (isset($title)) {
				echo "<title>$title</title>";
			}
		?>

		<link rel="shortcut icon" href="img/fav_icon.png" type="image/x-icon">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<link rel="stylesheet" type="text/css" href="css/custom.css">
		<link rel="stylesheet" type="text/css" href="css/ladda-themeless.min.css">
		<link rel="stylesheet" type="text/css" href="css/ladda.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
		<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
		
		<!-- włączenie jQuery ma być tutaj inaczej nie dziala pod operą --> 
		<script language="javascript" type="text/javascript" src="js/Lib/jquery-1.11.0.min.js"></script>
		
		<script type="text/javascript" src="js/Lib/bootstrap-datetimepicker.js" charset="UTF-8"></script>
		<script type="text/javascript" src="js/Lib/bootstrap-datetimepicker.pl.js" charset="UTF-8"></script>
		<?php
			if (isset($csses)) {
				foreach ($csses as $value) {
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$value\">";
				}
				echo "\n";
			}
			$dataPrinted = false;
			if (isset($scripts)) {
				foreach ($scripts as $value) {
					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$value\"></script>";
					if ($dataPrinted == false) {
						$dataPrinted = true;
					}
				}
			}
			if (isset($scriptsDefer)) {
				foreach ($scriptsDefer as $value) {
					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$value\" defer></script>";
					if ($dataPrinted == false) {
						$dataPrinted = true;
					}
				}
			}
			if ($dataPrinted == true) {
				echo "\n";
			}
		?>
	</head>

	<body style="background-image: url('img/books.jpg'); padding-top: 70px; height: 100%;">
		<?php include_once("Navbar.php"); ?>
		<div id="wrapper" class="container col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
			<div id="content_wrapper">
				<div class="panel col-sm-12 col-md-12 col-lg-12" style="padding: 20px; background: rgba(250, 250, 250, 1.0);
				box-shadow: 2px 2px 12px #666; box-shadow: -2px -2px 12px #666;
				">

				<noscript>
					<div class="alert alert-danger" style="width: 70%; margin-left: auto; margin-right: auto; text-align: justify;">
						<h4 style="text-align: center; color: #d2322d; font-weight: bold;">Wymagana obsługa JavaScript!</h4>
						<p>
						Wygląda na to, że Twoja przeglądarka nie obsługuje języka JavaScript lub ta funkcjonalność została wyłączona. 
						Zalecamy zmienić przegladarkę lub włączyć obsługę JavaScript, aby móc swobodnie korzystać z naszego serwisu.
						</p>
					</div>
					<?php
						if(!(isset($_GET['disabled']))) {
							echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://' . Settings::getAdress() . '?disabled=true">';
						}
					?>
				</noscript>