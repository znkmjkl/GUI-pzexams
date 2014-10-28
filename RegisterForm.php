<?php
	include_once("lib/Lib.php");
	
	if (isset($_SESSION['USER']) && $_SESSION['USER'] != "") {
		header('Location: UserSite.php'); 
	}
	
	if ( Settings::getAuthorizationUseCode() == true 
		&& isset($_SESSION['codeActivationStepCompleted']) 
		&&  $_SESSION['codeActivationStepCompleted'] !== 'stepCompleted' 
	) { 
		header('Location: InsertActivationCode.php'); 
	} 
	 
	
	$title = "$appName - Rejestracja";
	$scriptsDefer = array("js/ValidateRegisterForm.js");
	include("html/Begin.php");
?>

		<?php 
			if (isset($_SESSION['formErrorCode'])) {
				echo '<div class="alert alert-danger">' ;
				echo '<a href="#" class="close" data-dismiss="alert"> &times; </a>' ; 
				if ($_SESSION['formErrorCode'] == 'invalidCaptcha') {  
					echo '<strong>Rejestracja nie powiodła się! Wprowadzony kod jest nieprawidłowy.</strong>'; 
					unset($_SESSION['formErrorCode']);
				} 
				else if ($_SESSION['formErrorCode'] == 'userAlreadyInDB') {  
					echo '<strong>Rejestracja nie powiodła się! Na podany email już zarejestrowano konto.</strong>';
					unset($_SESSION['formErrorCode']);
				} 
				echo '</div>' ; 
			}
		?> 
		
		<form class="form-horizontal" role="form" id="register_form" method="post" action="controler/HandlingRegisterForm.php">
			<div class="form-group">
				<fieldset style="padding-left:20px;padding-right:20px;">
					<legend>Rejestracja w serwisie <?php echo "$appName" ?></legend>
				</fieldset>	
				<!--<div class="row">
					<h2 class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-xs-5 col-sm-5 col-md-5"> Zarejestruj Konto </h2>
				</div>
				<div class="row">
					<div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-xs-5 col-sm-5 col-md-5">  <hr style="color: #123455;">  </div>
				</div> -->
			</div>
			<p style="margin-top: -20px; margin-left:40px; margin-bottom: 40px;">
			Witamy w formularzy rejestracyjnym serwisu <?php echo "$appName" ?>! Jest nam niezmiernie miło, że chcesz dołączyć do grona egzaminatorów. Pamiętaj, że nas serwis jest w pełni darmowy i rejestracja w nim nic cię nie kosztuje.
			<br /> <br />
			* - pola obowiązkowe przy rejestracji.
			</p>
			
			<div style="margin-left: 40px">
			<div class="form-group">
				<label for="email" class="col-xs-2 col-sm-2 col-md-2 control-label">E-mail* </label>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<input type="email" required class="form-control" id="email" placeholder="Wprowadź adres e-mail" title="" name="email" value="<?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; } else { echo '';  }?>">
				</div> 
				<span class="help-block" id="email-error-message" >
					
				</span>
			</div>
			<!-- <div class="form-group">
				<label for="email-repet" class="col-xs-2 col-sm-2 col-md-2 control-label">Potwierdź e-mail </label>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<input type="email" required class="form-control" id="email" placeholder="Wprowadź ponownie e-mail" title="">
				</div> 
				<span class="help-block" id="email-error-message" >
						<span style="background-color:#F13333;" class="badge pull-left ">!</span>
					<span style="padding:5px"> Nieprawidłowy adress.</span>
				</span>
			</div> --> 
			<div class="form-group">
				<label for="passwd" class="col-xs-2 col-sm-2 col-md-2 control-label"> Hasło* </label>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<input type="password" required class="form-control inputPassword" id="passwd" name="passwd" placeholder="Wprowadź Hasło" title="">
				</div>
				<span class="help-block" id="passwd-error-message" >
					
				</span>
			</div>
			<div class="form-group">
				<label for="passwd-repat" class="col-xs-2 col-sm-2 col-md-2 control-label"> Potwierdź hasło* </label>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<input type="password" required class="form-control inputPassword" id="passwd-repeat" placeholder="Powtórz Haslo" title="">
				</div>
				<span class="help-block" id="passwd-repat-error-message" >
					
				</span>
			</div>
			<br />
			<div class="form-group">
				<label for="firstname" class="col-xs-2 col-sm-2 col-md-2 control-label">Imię</label>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<input type="text" class="form-control" id="firstname" placeholder="Wprowadź Imię" name="name" value="<?php if(isset($_SESSION['name'])){ echo $_SESSION['name']; } else { echo '';  }?>">
				</div>
			</div>
			<div class="form-group">
				<label for="lastname" class="col-xs-2 col-sm-2 col-md-2 control-label">Nazwisko</label>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<input type="text" class="form-control" id="lastname" placeholder="Wprowadź Nazwisko" name="surname" value="<?php if(isset($_SESSION['surname'])){ echo $_SESSION['surname']; } else { echo '';  }?>">
				</div>
			</div>  
			<div class="form-group">
				<label for="gender"  class="col-xs-2 col-sm-2 col-md-2 control-label"> Płeć </label>
				<div class="col-xs-4 col-sm-4 col-md-4" >
					<select class="form-control" id="gender" name="gender">
						<option>- Wybierz płeć -</option>
						<option>Kobieta</option>
						<option>Mężczyzna</option>
					</select>
				</div> 
			</div>
			<br /> 
			<div class="form-group" >
					<label class="col-xs-2 col-sm-2 col-md-2 control-label">Przepisz kod zabezpieczający</label>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<img id="captcha" src="lib/SecureImage/securimage_show.php"  class="img-thumbnail .img-rounded:2px" style="margin-right:20px;" alt="CAPTCHA IMAGE" />
						<div style="display:inline-block;vertical-align:middle;float:none;">
							<a href="#" onclick="document.getElementById('captcha').src = 'lib/SecureImage/securimage_show.php?' + Math.random(); return false"> 
							<img id="reload-image" src="lib/SecureImage/images/refresh.png" alt="Odśwież Obrazek" />
							</a> 
						</div>
					</div>
			</div>
			
			<div class="form-group">
				<div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xs-4 col-sm-4 col-md-4">
					<input type="text" class="form-control" name="captcha_code" id="captcha_code" placeholder="Wprowadź kod znajdujący się na obrazku"/> 
					<span class="help-block" id="captcha-error-message">

					</span>
				</div>
			</div> 
			
			<div class="form-group">
				<div class="control-group"> 
					<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xs-2 col-sm-2 col-md-2">
						<button type="submit" class="btn btn-primary btn-block" name="submitButton" value="submit">Zarejestruj konto</button>
					</span>
					<span class="col-xs-2 col-sm-2 col-md-2">
						<button type="button" class="btn btn-default btn-block" name="clearButton" onclick="window.location.href =  'controler/HandlingRegisterForm.php';">Wyczyść</button>
					</span>
			</div>
			</div>
		</form>
	</div>

<?php include ("html/End.php"); ?> 
