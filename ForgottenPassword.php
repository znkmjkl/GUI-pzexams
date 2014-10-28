<?php
	
	include_once("lib/Lib.php");
	
	$title = "$appName - Pomoc";
	$scripts = array("js/LicenceHelp.js");
	include("html/Begin.php");
	
	if (isset($_SESSION['forgottenPass']) && $_SESSION['forgottenPass'] != "" && $_SESSION['forgottenPass'] != "success"){
		echo '<div class="alert alert-danger">';
		echo '<a href="#" class="close" data-dismiss="alert"> &times; </a>';
		if($_SESSION['forgottenPass'] == 'noEmailInDB'){
			echo '<strong>Nie ma takiego adresu email w bazie! </strong>';
		} elseif($_SESSION['forgottenPass'] == 'updateError'){
			echo '<strong>Wystąpił błąd przy próbie zmianie hasła! Spróbuj ponownie później, albo skontaktuj się z administracją</strong>';
		} elseif($_SESSION['forgottenPass'] == 'emailError'){
			echo '<strong>Wystąpił błąd przy próbie wysłania wiadomości! Spróbuj ponownie później, albo skontaktuj się z administracją. </strong>';
		}
		
		
		echo '</div>';
		unset($_SESSION['forgottenPass']);
	}
?>
	<form class="form-horizontal" role="form" id="activation_code_form" method="post" action="controler/HandlingForgottenPasswordForm.php">
			<div class="form-group">
				<fieldset style="padding-left:20px;padding-right:20px;">
					<legend> Odzyskiwanie dostępu do konta w serwisie PZ-Exams </legend>
				</fieldset>	
			</div>
			<div class="form-group"> 
				<h4 class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-xs-10 col-sm-10 col-md-10" style="text-align: center;"> Wprowadź swój adres email, który podałeś przy rejestracji</h4> 
			</div>
			<div class="form-group">
				<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xs-8 col-sm-8 col-md-8">
					<label for="activation-code" class="col-xs-2 col-sm-2 col-md-2 control-label">Adres email</label>
					<div class="col-xs-8 col-sm-8 col-md-8">
						<input type="email" class="form-control" id="email" placeholder="Wprowadź adres email" name="email">
					</div>
				</span>
			</div>
			
			<br /> 
					
			<div class="form-group">
				<div class="row"> 
					<span class="col-xs-offset-4 col-sm-offset-4 col-md-offset-4 col-xs-4 col-sm-4 col-md-4">
						<button type="submit" class="btn btn-success btn btn-block" name="submitActivationCodeButton" value="submit">Wyślij nowe hasło</button>
					</span>
				</div>
			</div>
		</form>
<?php
	include ("html/End.php");
?>