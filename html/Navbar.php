<div	class="navbar	navbar-inverse	navbar-fixed-top"	style="background:	rgba(0,0,0,0.85);	box-shadow:	2px	2px	20px	#444444;">
		<div	class="container	col-md-12"	style="padding:	0px;">
		<div	class="navbar-header"	style="padding-left:	0px;">
			<button	type="button"	class="navbar-toggle"	data-toggle="collapse"	data-target=".navbar-collapse">
			<span	class="icon-bar"></span>
			<span	class="icon-bar"></span>
			<span	class="icon-bar"></span>
			</button>

			<ul	class="nav	navbar-nav	pull-left"	style="padding-right:	0px;">
			<li><a	id="home"	class="navbar-brand"	href="index.php" style='padding: 12px;'><img	style	=	"width:	160px"	src="img/logo_button.png"></a></li>
			<!--  -->
			<?php	if(isset($_SESSION['USER'])	&&	$_SESSION['USER']	!=	""){?>
				<li><a	class="navbar-brand"	href="Help.php">Pomoc</a></li>
				<li><a	class="navbar-brand"	href="Contact.php">Kontakt</a></li>
			<?php } ?>
			</ul>
			<?php
				if (Settings::getDebug() == true) {
					echo "<a class=\"navbar-brand\" href=\"tests/index.php\">Testy</a>\n";
				}
			?>
		</div>
		<div	class="collapse	navbar-collapse"	style="padding:	0px;">
			<ul	class="nav	navbar-nav	pull-right"	style="padding-right:	0px;">
				<?php	if(isset($_SESSION['USER'])	&&	$_SESSION['USER']	!=	""){	?>
				<li	class="navbar-form"	style="padding-right:	0px;">
					<?php
						$user = unserialize($_SESSION['USER']);
					?>
					<form	action="UserSite.php">
						<div class="btn-group">
							<button class="btn btn-info"><i class="glyphicon glyphicon-user" style="margin-right: 5px;"></i><b> 
							<?php
								if ($user->getFirstName() != NULL && $user->getSurname() != NULL)
									echo ' ' . $user->getFirstName() . ' ' . $user->getSurname();
								else
									echo ' ' . $user->getEmail();
							?>
							</b></button>
						
							<button class="btn btn-info dropdown-toggle" data-toggle="dropdown">	
								<span class="caret"></span>
								<b></b>
							</button>
							<ul class="dropdown-menu" style="background: rgba(0,0,0,0.75); box-shadow: 2px 2px 20px #444444;" role="menu">
								<li role="presentation" class="dropdown-header" style="margin-left: -10px">Opcje egzaminatora</li>
								<li><a href="AddExam.php" id="user_m" style="color:white"><i class="glyphicon glyphicon-plus"></i>  <b>Dodaj egzamin</b></a></li>
								<li><a href="ExamList.php" id="user_m" style="color:white"><i class="glyphicon glyphicon-list"></i>  <b>Aktualne egzaminy</b></a></li>
								<li><a href="ExamListArchives.php" id="user_m" style="color:white"><i class="glyphicon glyphicon-floppy-disk"></i>  <b>Archiwalne egzaminy</b></a></li>
								<li><a href="UserEdit.php" title="Edytuj profil" id="user_m" style="color:white"><i class="glyphicon glyphicon-cog"></i>  <b>Edytuj Profil</b></a></li>
								<?php
									if ($user->getRight() === "administrator" || $user->getRight() === "owner") {
										echo '<li role="presentation" class="divider"></li>';
										echo '<li role="presentation" class="dropdown-header" style="margin-left: -10px">Opcje administratora</li>';
										echo '<li><a href="AdminSystemStats.php" id="user_m" style="color:white"><i class="glyphicon glyphicon-stats" style="margin-right: 4px;"></i><b>Statystyki serwisu</b></a></li>';
										echo '<li><a href="AdminUsers.php" id="user_m" style="color:white"><i class="glyphicon glyphicon-star" style="margin-right: 4px;"></i><b>Użytkownicy</b></a></li>';
										echo '<li><a href="AdminStudents.php" id="user_m" style="color:white"><i class="glyphicon glyphicon-user" style="margin-right: 4px;"></i><b>Studenci</b></a></li>';
										echo '<li><a href="AdminExams.php" id="user_m" style="color:white"><i class="glyphicon glyphicon-file" style="margin-right: 4px;"></i><b>Egzaminy</b></a></li>';
										echo '<li><a href="AdminEdit.php" title="Ustawienia" id="user_m" style="color:white"><i class="glyphicon glyphicon-cog" style="margin-right: 4px;"></i><b>Ustawienia</b></a></li>';
									}
								?>
							</ul>
						</div>
					</form>
				</li>
				<li	class="navbar-form"	style="padding-right:	0px;">
						<form	action="controler/LogOff.php">
								<button	type="submit"	class="btn	btn-danger"><i class="glyphicon glyphicon-log-out"></i> <b>Wyloguj</b></button>
						</form>
				</li>	
		<?php	}	else	{	?>
					
				
				<li	class="navbar-form"	style="margin-left:-20px;	padding-right:	0px;">
					<?php 
						if (Settings::getAuthorizationUseCode() == true && $_SESSION['codeActivationStepCompleted'] != 'stepCompleted') {
							echo '<form	action="InsertActivationCode.php">';  
						} else { 
							echo '<form	action="RegisterForm.php">';
						}
					?>
						<button	type="submit" class="btn btn-info"><i class="glyphicon glyphicon-book" style="margin-right: 5px;"></i><b>Rejestracja</b></button>
					</form>
				</li>	
		<?php	}	?>
			</ul>
		</div>
		</div>
	</div>