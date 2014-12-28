<?php
	include_once("lib/Lib.php");
	
	$title = "$appName - Strona Główna";
	$scriptsDefer = array("js/index.js");
	include("html/Begin.php");	



	if(isset($_SESSION['USER']) && $_SESSION['USER'] != ''){
		header('Location: UserSite.php');
		ob_end_flush();
		return;
	}

	if (isset($_SESSION['formSuccessCode'])) {
		echo '<div class="alert alert-success" >';
		echo '<a href="#" class="close" data-dismiss="alert"> &times; </a>'; 
		
		echo '<strong>Użytownik zarejestrowany poprawnie. E-mail z linkiem aktywacyjnym został wysłany. </strong>';
		
		echo '</div>'; 
		
		unset($_SESSION['formSuccessCode']);
	}

	if (isset($_SESSION['ERROR'])) {
		echo '<div class="alert alert-danger">';
		echo '<a href="#" class="close" data-dismiss="alert"> &times; </a>'; 
		if($_SESSION['ERROR'] == '1') {
			echo '<strong>Nie ma takiego użytkownika w bazie!</strong>';
		} elseif ($_SESSION['ERROR'] == '2') {
			echo '<strong>Podane hasło jest niepoprawne!</strong>';
		} elseif ($_SESSION['ERROR'] == '3') {
			echo '<strong>Konto nie zostało aktywowane! Proszę aktywować konto poprzez link wysłany na adres mailowy.</strong>';
		}
		echo '</div>' ;
		unset($_SESSION['ERROR']);
	}

	if (isset($_SESSION['forgottenPass']) && $_SESSION['forgottenPass'] == "success"){
		echo '<div class="alert alert-success">';
		echo '<a href="#" class="close" data-dismiss="alert"> &times; </a>'; 
		
		echo '<strong>Na podany adres email została wysłana wiadomość z nowym hasłem! </strong>';
		
		echo '</div>';
		unset($_SESSION['forgottenPass']);
	}
?>
<style>
    .panel{
        background: rgba(250, 250, 250, 0.6);
    }
</style>
<div class="container" >
	<div class="col-md-4 col-md-offset-4" style="height:75vh;">
		<form class="form-signin" role="form" style="margin-right:10px;margin-left:10px; margin-top:40%" method="post"	action="controler/LogIn.php">
			<h3	style="text-align:center;	font-size:27px; font-weight:bold;	padding-bottom:15px;">Logowanie	do systemu</h3>
			
			<input type="email" name="email" class="form-control" placeholder="Adres e-mail" required	autofocus style="margin-bottom:3px;">
			
			<input type="password" style="margin-top:10px;" name="pass"	class="form-control" placeholder="Hasło" required>			
			
			<label class="">
				<a href="ForgottenPassword.php">Zapomniałeś hasła?</a>
			</label>
			<button	type="submit" class="btn	btn-success	btn-lg	btn-block"	style="margin-top:20px;	margin-bottom:5px;"><b>Zaloguj</b></button>
		</form>
	</div>	

<?php 
	include("html/End.php");
?>
