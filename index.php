<?php
	include_once("lib/Lib.php");
	
	$title = "$appName - Strona Główna";
	$scriptsDefer = array("js/index.js");
	include("html/Begin.php");	
	if (isset($_SESSION['formSuccessCode'])) {
		echo '<div class="alert alert-success">';
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

<div class="container">
	<div id="karuzela" class="carousel slide">
		<!-- Kropki -->
		<ol class="carousel-indicators">
			<li data-target="#karuzela" data-slide-to="0" class="active"></li>
			<li data-target="#karuzela" data-slide-to="1"></li>
			<?php
				if (!(isset($_SESSION['USER'])&&($_SESSION['USER']!=''))) {
					echo '<li data-target="#karuzela" data-slide-to="2"></li>';
				}
			?>
		</ol>
    
		<!-- Slajdy -->
		<div class="carousel-inner">
			<?php
				if (!(isset($_SESSION['USER'])&&($_SESSION['USER']!=''))) {
					echo '
					<div class="item active">
						<a href="RegisterForm.php">
							<img src="img/Rejestracja.jpg" alt="">
						</a>
						<!-- Opis slajdu -->
						<div class="carousel-caption">
							<a href="RegisterForm.php" id="slideTitle">
								<h4>Rejestracja</h4>
								<p>Dołącz do serwisu, który zmienia szare życie tysięcy egzaminatorów!</p>
							</a>
						</div>
					</div>';
				}

				if (!(isset($_SESSION['USER'])&&($_SESSION['USER']!=''))) {
					echo'<div class="item">';
				} else { 
					echo'<div class="item active">';
				}
			?>
			<a href="Help.php">
				<img src="img/Pomoc.jpg" alt="">
			</a>
			<!-- Opis slajdu -->
			<div class="carousel-caption">
				<a href="Help.php" id="slideTitle">
					<h4>Pomoc</h4>
					<p>Chcesz uzyskać informację na temat naszego systemu? Zajrzyj do obszernej instrukcji przygotowanych przez naszych specjalistów.</p>
				</a>
			</div>
		</div>
	      
		<div class="item">
			<a href="Authors.php">
				<img src="img/Autorzy.jpg" alt="">
			</a>
			<!-- Opis slajdu -->
			<div class="carousel-caption">
				<a href="Authors.php" id="slideTitle">
					<h4>Autorzy</h4>
					<p>Chcesz dowiedzieć się więcej o naszej drużynie developerskiej. Zajrzyj tutaj!</p>
				</a>
			</div>
		</div>      
	</div>
    
	<!-- Strzalki -->
	<a class="left carousel-control" href="#karuzela" data-slide="prev">
		<span class="icon-prev"></span>
	</a>
	<a class="right carousel-control" href="#karuzela" data-slide="next">
		<span class="icon-next"></span>
	</a>
	</div>
</div>

<div class="container text-center">
	<h3>Tworzenie i zarządzanie egzaminami nigdy nie było takie proste!</h3>
	<p style="margin-bottom: 30px;">
	PZ-Exams to platforma służąca do tworzenia egzaminów ustnych jak i rejestracji na nie, na której mogą polegać zarówno wykładowcy jak i studenci. <br/>
	Nimniejszy serwis została opracowana przez zespół studentów, którzy doskonale zdają sobie sprawę z ograniczeń  uczelnianych systemów takich jak USOS. <br/>
	Dlatego jeżeli jesteś nauczycielem akdemickim, który uważa, że egzaminy ustne są jedyną dobrą formą egzaminu. To znaczy, że ten serwis jest właśnie dla ciebie!
	</p>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-4 col-sm-4 col-md-4">
				<a href="Licence.php">
					<img src="img/IconTechnology.png" alt="">
				</a>
				<h4>Nowoczesne technologie</h4>
				<p>Wykorzystujemy tylko najnowocześniejsze technologie. Sprawdź na czym zbudowaliśmy nasz serwis.</p>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4">
				<a href="Contact.php">
					<img src="img/IconContact.png" alt="">
				</a>	
				<h4>Formularz kontaktowy</h4>
				<p>Systematycznie staramy się rozwijać nasz serwis. Jeżeli masz jakiekolwie uwagi to skontaktuj się z drużyną deweloperską!</p>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4">
				<a href="https://github.com/klugier/pz-exams">
					<img src="img/IconCode.png" alt="">
				</a>
				<h4>Otwarte oprogramowanie</h4>
				<p>Kod źródłowy naszego serwisu jest dostępny publicznie.</p>
			</div>
		</div>
</div>
<a href="#" data-toggle="tooltip" tooltip-placement="top" title="" data-original-title="Default tooltip Defauasdasdsad asdadlt Defauasdasdsad asdadlt Defauasdasdsad asdadlt Defauasdasdsad asdadlt Defauasdasdsad asdadlt Defauasdasdsad asdadlt Defauasdasdsad asdadlt ">test top</a><br/>
<a href="#" data-toggle="tooltip" tooltip-placement="right" title="" data-original-title="Defauasdasdsad asdadlt tooltip">test right</a><br/>
<a href="#" style="text-alight:right; margin-left:50px;" data-toggle="tooltip" tooltip-placement="left" title="" data-original-title="Default tooltip">test left</a><br/>
     
            
<script>

</script>

<?php 
	include("html/End.php");
?>
