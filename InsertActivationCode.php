<?php
	include_once("lib/Lib.php") ; 
	
	$title = "$appName - Wprowadź kod aktywacyjny";
	$scriptsDefer = array("js/ValidateRegisterForm.js");
	include("html/Begin.php");
?>

		<?php 
			if (isset($_SESSION['activationCodeFormErrorCode'])) {
				echo '<div class="alert alert-danger">' ;
				echo '<a href="#" class="close" data-dismiss="alert"> &times; </a>' ; 
				if ($_SESSION['activationCodeFormErrorCode'] == 'invalidActivationCode') {  
					echo '<strong>Dostęp do rejestracji zablokowany. Wprowadzony kod jest nieprawidłowy. </strong>'; 
					unset($_SESSION['activationCodeFormErrorCode']);
				} 
				echo '</div>' ; 
			}
		?> 
		
		<form class="form-horizontal" role="form" id="activation_code_form" method="post" action="controler/HandlingActivationCodeForm.php">
			<div class="form-group">
				<fieldset style="padding-left:20px;padding-right:20px;">
					<legend> Wprowadź kod aktywacyjny </legend>
				</fieldset>	
			</div>
			<div class="form-group"> 
				<h4 class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-xs-10 col-sm-10 col-md-10" style="text-align: center;"> Rejestracja konta w serwisie wymaga wprowadzenia kodu aktywacyjnego, który można uzyskać od administratora.</h4> 
			</div>
			<div class="form-group">
				<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xs-8 col-sm-8 col-md-8">
					<label for="activation-code" class="col-xs-2 col-sm-2 col-md-2 control-label">Kod</label>
					<div class="col-xs-8 col-sm-8 col-md-8">
						<input type="text" class="form-control" id="activation-code" placeholder="Wprowadź kod aktywacyjny" name="activationCode">
					</div>
				</span>
			</div>
			
			<br /> 
					
			<div class="form-group">
				<div class="row"> 
					<span class="col-xs-offset-4 col-sm-offset-4 col-md-offset-4 col-xs-4 col-sm-4 col-md-4">
						<button type="submit" class="btn btn-success btn btn-block" name="submitActivationCodeButton" value="submit">Weryfikuj kod aktywacyjny</button>
					</span>
				</div>
			</div>
		</form>

<?php include ("html/End.php"); ?> 
