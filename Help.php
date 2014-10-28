<?php 
	include_once("lib/Lib.php");

	$title = "$appName - Pomoc";
	include("html/Begin.php");
?> 

<div class="container"> 
	<h2>Obsługiwane domeny</h2>
	<hr/>
	W chwili obecnej obsługujemy użytkowników posiadających adresy e-mail z następujących domen: <br />
	<ul>
		<?php
			$domains = Settings::getDomains();
			if ($domains == null) {
				echo "<li><b>Aktualnie obsługiwane są wszystkie domenu</b></li>";
			} else {
				foreach ($domains as $domain) {
					echo "<li>" . $domain . "</li>\n";
				}
			}
		?>
	</ul>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<h2>Spis treści</h2>
	<hr/>
	<ol>
		<li><a href="#powitalny">Ekran powitalny</a></li>
		<li><a href="#rejestracja">Rejestracja w systemie</a></li>
		<li><a href="#logowanie">Logowanie</a></li>				
		<li><a href="#po_zalogowaniu">Po zalogowaniu</a></li>
		<li><a href="#menu_rozwijane">Menu rozwijane</a></li>
		dodaj_egzamin
		dodaj_termin
		dodawanie_studentow_pierwszy
		zmiana_formatu_email
		dodawanie_maili
		lista_aktualnych_egzaminow
		lista_studentow_dla_egzaminu
		dodaj_kolejnych_do_egzaminu
	</ol>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="powitalny"></a>
	<h2>Tytuł</h2>
	<hr/>
	<img src="img/help/01_poczatek.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="rejestracja"></a>
	<h2>Rejestracja w systemie.</h2>		
	<hr/>
	<img src="img/help/01_kod_aktywacyjny.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>		

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="logowanie"></a>
	<h2>Rejestracja w systemie</h2>		
	<hr/>
	<img src="img/help/01_logowanie.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>		

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="po_zalogowaniu"></a>
	<h2>Po zalogowaniu</h2>		
	<hr/>
	<img src="img/help/02_po_zalogowaniu.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="menu_rozwijane"></a>
	<h2>Menu rozwijane</h2>		
	<hr/>
	<img src="img/help/02_po_zalogowaniu.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="dodaj_egzamin"></a>
	<h2>Dodaj egzamin</h2>		
	<hr/>
	<img src="img/help/03_dodaj_egzamin.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="dodaj_termin"></a>
	<h2>Dodawanie terminu egzaminu</h2>		
	<hr/>
	<img src="img/help/03_dodawanie_terminu.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
	<img src="img/help/03_termin_dodano.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="dodawanie_studentow_pierwszy"></a>
	<h2>Dodawanie studentów</h2>		
	<hr/>
	<img src="img/help/03_lista_studentow_pierwszy.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="zmiana_formatu_email"></a>
	<h2>Zmiana formatu wprowadzanych adresów e-mail</h2>		
	<hr/>
	<img src="img/help/03_lista_studentow_format_mail.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="dodawanie_maili"></a>
	<h2>Dodawanie studentów do egzaminu</h2>
	<hr/>
	<img src="img/help/03_lista_studentow_dodawanie.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="lista_aktualnych_egzaminow"></a>
	<h2>Lista aktualnych egzaminów</h2>		
	<hr/>
	<img src="img/help/04_lista_aktualnych.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="lista_studentow_dla_egzaminu"></a>	
	<h2>Lista studentów przypisanych do egzaminu, wysyłanie kodów studentom</h2>		
	<hr/>
	<img src="img/help/04_lista_studentow.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="dodaj_kolejnych_do_egzaminu"></a>
	<h2>Dodaj kolejnych studentów do egzaminu</h2>		
	<hr/>
	<img src="img/help/04_dodaj_studentow.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="edycja_egzaminu"></a>
	<h2>Edycja egzaminu</h2>		
	<hr/>
	<img src="img/help/04_edytuj_egzamin.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="archiwalna"></a>
	<h2>Lista archiwalna egzaminów</h2>		
	<hr/>
	<img src="img/help/05_archiwalne.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="edytuj_profil"></a>
	<h2>Edytuj profil</h2>		
	<hr/>
	<img src="img/help/06_edytuj_profil.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-xs-12 col-sm-12 col-md-12">
	<a name="kontaktowy"></a>
	<h2>Formularz kontaktowy</h2>		
	<hr/>
	<img src="img/help/07_formularz_kontaktowy.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<?php
	include ("html/End.php");
?>
