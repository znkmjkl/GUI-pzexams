<?php
		include_once("lib/Lib.php");
	
	if	(!isset($_SESSION['USER'])	||	$_SESSION['USER']	==	"")	{
		header('Location:	index.php'	);	
		}else{
		$user	=	UserDatabase::getUser(unserialize($_SESSION['USER'])->getID());
		$_SESSION['nameEdit']	=	$user->getFirstName();
		$_SESSION['surnameEdit']	=	$user->getSurname();
		$_SESSION['genderEdit']	=	$user->getGender();
		}
	
		$title	=	"$appName	-	Edycja	Danych";
		$scriptsDefer	=	array("js/ValidateRegisterForm.js");
		include("html/Begin.php");
		include("html/UserPanel.php");
		
		/*
		echo	$_SESSION['USER']."</br>";
		echo	"Object	User	Info	<br	/>	";	
		echo	"Id:	"		.	$user->getID()		.	"<br	/>	"	;
		echo	"Email:	"	.	$user->getEmail()		.	"<br	/>	"	;	
		echo	"Password:	"	.	$user->getPassword()	.	"<br	/>	"	;
		echo	"Name:	"		.	$user->getFirstName()	.	"<br	/>	"	;//Not	in	session	User
		echo	"Surname:	"	.	$user->getSurname()	.	"<br	/>	"	;//Not	in	session	User
		echo	"Gender:	"	.	$user->getGender()	.	"<br	/>	"	;//Not	in	session	User
		*/
?>
<?php
	
	if	(isset($_SESSION['formSuccessCode']))	{
		echo	'<div	class="alert	alert-success">'	;
		echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>'	;			
	
		if	($_SESSION['formSuccessCode']	==	'passwordChanged')	{	
			echo	'<strong>Poprawnie	zmieniono	hasło.</strong>';	
			unset($_SESSION['formSuccessCode']);
		}
		echo	'</div>'	;	
	}
	if	(isset($_SESSION['formSuccessCode1']))	{
		echo	'<div	class="alert	alert-success">'	;
		echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>'	;		
		if	($_SESSION['formSuccessCode1']	==	'nameChanged')	{	
			echo	'<strong>Poprawnie	zmieniono	imię.</strong>';	
			unset($_SESSION['formSuccessCode1']);
		}
		echo	'</div>'	;	
	}
	if	(isset($_SESSION['formSuccessCode2']))	{
		echo	'<div	class="alert	alert-success">'	;
		echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>'	;		
		if	($_SESSION['formSuccessCode2']	==	'surnameChanged')	{	
			echo	'<strong>Poprawnie	zmieniono	nazwisko.</strong>';	
			unset($_SESSION['formSuccessCode2']);
		}
		echo	'</div>'	;	
	}
	if	(isset($_SESSION['formSuccessCode3']))	{
		echo	'<div	class="alert	alert-success">'	;
		echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>'	;		
		if	($_SESSION['formSuccessCode3']	==	'genderChanged')	{	
			echo	'<strong>Poprawnie	zmieniono	płeć.</strong>';	
			unset($_SESSION['formSuccessCode3']);
		}
		echo	'</div>'	;	
	}
	
	if	(isset($_SESSION['formErrorCode']))	{
		echo	'<div	class="alert	alert-danger">'	;
		echo	'<a	href="#"	class="close"	data-dismiss="alert">	&times;	</a>'	;	
		if	($_SESSION['formErrorCode']	==	'passwordIncorrect')	{	
			echo	'<strong>Uwaga!!!	Zmiana	Hasła	nie	powiodła	się.	Wprowadzone	hasło	jest	nieprawidłowe.	</strong>';	
			unset($_SESSION['formErrorCode']);
		}
		else	if	($_SESSION['formErrorCode']	==	'databaseError')	{	
			echo	'<strong>Uwaga!!!	Zmiana	nie	powiodła	się.	Błąd	Bazy	Danych.	</strong>';	
			unset($_SESSION['formErrorCode']);
		}
		echo	'</div>'	;	
	}
?>
<h1>Edytuj profil</h1>
<hr />
<form class="form-horizontal" role="form" id="passwd_form" method="post" action="controler/HandlingUserEdit.php">
	<fieldset class="col-xs-12	col-sm-12	col-md-12">
		<legend>Zmiana	hasła</legend>
		<div class="form-group">
			<label for="passwd-old" class="col-xs-2	col-sm-2	col-md-2	control-label">	Stare Hasło	</label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="password" required class="form-control	inputPassword" id="passwd-old" name="passwd-old" placeholder="Wprowadź Stare Haslo" title="">
			</div>
		</div>
		<div class="form-group">
			<label for="passwd" class="col-xs-2	col-sm-2	col-md-2	control-label">	Nowe Hasło</label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="password" required class="form-control	inputPassword" id="passwd" name="passwd" placeholder="Wprowadź Nowe Haslo" title="">
			</div>
			<span class="help-block" id="passwd-error-message">
			</span>
		</div>
		<div class="form-group">
			<label for="passwd-repat" class="col-xs-2	col-sm-2	col-md-2	control-label">	Potwierdź Nowe Hasło </label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="password" required class="form-control	inputPassword" id="passwd-repeat" placeholder="Powtórz Nowe Haslo" title="">
			</div>
			<span class="help-block" id="passwd-repat-error-message">
			</span>
		</div>
		<div class="form-group">
			<span class="col-xs-offset-2	col-sm-offset-2	col-md-offset-2	col-xs-2	col-sm-2	col-md-2">
				<button type="submit" class="btn	btn-primary" name="submitButtonPassword" value="submit">Zmień Hasło</button>
			</span>
		</div>
	</fieldset>
</form>
<form class="form-horizontal" role="form" id="firstname_form" method="post" action="controler/HandlingUserEdit.php">
	<fieldset class="col-xs-12	col-sm-12	col-md-12">
		<legend>Zmiana ustawień osobistych</legend>
		<div class="form-group">
			<label for="firstname" class="col-xs-2	col-sm-2	col-md-2	control-label">Nowe	Imię</label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="text" class="form-control" id="firstname" placeholder="Wprowadź Imię" name="nameEdit" value="<?php	if(isset($_SESSION['nameEdit'])){	echo	$_SESSION['nameEdit'];	}	else	{	echo	'';	}?>">
			</div>
		</div>
		<div class="form-group">
			<label for="lastname" class="col-xs-2	col-sm-2	col-md-2	control-label">Nowe	Nazwisko</label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="text" class="form-control" id="lastname" placeholder="Wprowadź Nazwisko" name="surnameEdit" value="<?php	if(isset($_SESSION['surnameEdit'])){	echo	$_SESSION['surnameEdit'];	}	else	{	echo	'';	}?>">
			</div>
		</div>
		<div class="form-group">
			<label for="gender" class="col-xs-2	col-sm-2	col-md-2	control-label">Nowa	Płeć</label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<select class="form-control" id="genderEdit" name="genderEdit">
					<option><?php	if($_SESSION['genderEdit']	==	'male'){	echo	'Mężczyzna';	}	else	{	echo	'Kobieta';	}?></option>
					<option><?php	if($_SESSION['genderEdit']	==	'male'){	echo	'Kobieta';	}	else	{	echo	'Mężczyzna';	}?></option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xs-3 col-sm-3	col-md-3">
				<button type="submit" class="btn	btn-primary" name="submitButton" value="submit">Zmień ustawienia osobiste</button>
			</span>
		</div>
	</fieldset>
</form>
<?php	include	("html/End.php");	?>
