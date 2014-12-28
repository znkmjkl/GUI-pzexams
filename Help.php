<?php 
	include_once("lib/Lib.php");

	$title = "$appName - Pomoc";
	include("html/Begin.php");
?> 
<?php	if(!isset($_SESSION['USER']) || $_SESSION['USER'] == ''){
	header('Location: 403.php');
	ob_end_flush();
	return;

}
?>
<style>
	.col-md-9{
		float:none;
	}
	hr{
		height:2px;
		color: grey;
		background-color: grey;
	}
	#top-menu .active a{
		color:red;
		font-weight:bold;
	}
	#top-menu li{
		font-size:1.05em;
		padding-bottom:5px;		
	}
	a:hover, a:visited, a:focus{
		text-decoration: none;
	}

</style>
<div class="container col-md-offset-3"> 
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


<div class="navbar-example" style="position: fixed;top: 91px;display: inline-block;width: 20%; z-index:1000;">
	<h2>Spis treści</h2>
	<hr/>
	<ol id="top-menu">
		<li><a href="#strona_glowna">Strona główna użytkownika</a></li>						
		<li><a href="#nowy_egzamin">Tworzenie nowego egzaminu</a></li>
		<li><a href="#dodaj_termin">Dodawanie terminu egzaminu</a></li>
		<li><a href="#dodawanie_studentow1">Dodawanie studentów do egzaminu I</a></li>
		<li><a href="#zmiana_formatu_email">Format wprowadzanych adresów email</a></li>
		<li><a href="#dodawanie_studentow2">Dodawanie studentów do egzaminu II</a></li>
		<li><a href="#lista_aktualnych_egzaminow">Lista aktualnych egzaminów</a></li>
		<li><a href="#lista_studentow_dla_egzaminu">Lista studentów przypisanych do egzaminu, wysłanie kodów</a></li>
		<li><a href="#dodaj_kolejnych_do_egzaminu">Dodanie nowych osób do egzaminu</a></li>
		<li><a href="#edycja_egzaminu">Edycja egzaminu</a></li>
		<li><a href="#widok_egzaminu">Widok egzaminu</a></li>
		<li><a href="#lista_archiwalna">Lista archiwalna egzaminów</a></li>
		<li><a href="#edytuj_profil">Edycja danych profilu</a></li>
		<li><a href="#kontaktowy">Formularz kontaktowy</a></li>
	</ol>
</div>
		

<div class="container col-md-9 col-md-offset-3" id="strona_glowna" >
	<a name="strona_glowna"></a>
	<h2 style="margin-top:80px;">Strona główna użytkownika</h2>		
	<hr/>
	<img src="img/help/02_po_zalogowaniu.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="nowy_egzamin">
	<a name="dodaj_egzamin"></a>
	<h2 style="margin-top:80px;">Dodaj egzamin</h2>		
	<hr/>
	<img src="img/help/03_dodaj_egzamin.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="dodaj_termin">
	<a name="dodaj_termin"></a>
	<h2 style="margin-top:80px;">Dodawanie terminu(dnia) egzaminu</h2>		
	<hr/>
	<img src="img/help/03_dodawanie_terminu.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
	<img src="img/help/03_termin_dodano.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="dodawanie_studentow1">
	<a name="dodawanie_studentow_pierwszy"></a>
	<h2 style="margin-top:80px;">Dodawanie studentów do egzaminu I</h2>		
	<hr/>
	<img src="img/help/03_lista_studentow_pierwszy.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="zmiana_formatu_email">
	<a name="zmiana_formatu_email"></a>
	<h2 style="margin-top:80px;">Zmiana formatu wprowadzanych adresów e-mail</h2>		
	<hr/>
	<img src="img/help/03_lista_studentow_format_mail.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="dodawanie_studentow2">
	<a name="dodawanie_maili"></a>
	<h2 style="margin-top:80px;">Dodawanie studentów do egzaminu II</h2>
	<hr/>
	<img src="img/help/03_lista_studentow_dodawanie.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="lista_aktualnych_egzaminow">
	<a name="lista_aktualnych_egzaminow"></a>
	<h2 style="margin-top:80px;">Lista aktualnych egzaminów</h2>		
	<hr/>
	<img src="img/help/04_lista_aktualnych.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="lista_studentow_dla_egzaminu">
	<a name="lista_studentow_dla_egzaminu"></a>	
	<h2 style="margin-top:80px;">Lista studentów przypisanych do egzaminu, wysyłanie kodów studentom</h2>		
	<hr/>
	<img src="img/help/04_lista_studentow.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="dodaj_kolejnych_do_egzaminu">
	<a name="dodaj_kolejnych_do_egzaminu"></a>
	<h2 style="margin-top:80px;">Dodaj kolejnych studentów do egzaminu</h2>		
	<hr/>
	<img src="img/help/04_dodaj_studentow.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="edycja_egzaminu">
	<a name="edycja_egzaminu"></a>
	<h2 style="margin-top:80px;">Edycja egzaminu</h2>		
	<hr/>
	<img src="img/help/04_edytuj_egzamin.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="widok_egzaminu">
	<a name="widok_egzaminu"></a>
	<h2 style="margin-top:80px;">Widok egzaminu</h2>		
	<hr/>
	<img src="img/help/widok_egzaminu.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="lista_archiwalna">
	<a name="lista_archiwalna"></a>
	<h2 style="margin-top:80px;">Lista archiwalna egzaminów</h2>		
	<hr/>
	<img src="img/help/05_archiwalne.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="edytuj_profil">
	<a name="edytuj_profil"></a>
	<h2 style="margin-top:80px;">Edytuj profil</h2>		
	<hr/>
	<img src="img/help/06_edytuj_profil.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>

<div class="container col-md-9 col-md-offset-3" id="kontaktowy">
	<a name="kontaktowy"></a>
	<h2 style="margin-top:80px;">Formularz kontaktowy</h2>		
	<hr/>
	<img src="img/help/07_formularz_kontaktowy.jpg" alt="" class="col-xs-8 col-sm-8 col-md-8">
	<p class="col-xs-4 col-sm-4 col-md-4">Treść</p>
</div>


<script>
/*$(document).ready(function(){
	$('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash;
	    var $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 800, 'swing', function () {
	        window.location.hash = target;
	    });
	});	
});*/
var lastId,
    topMenu = $("#top-menu"),
    topMenuHeight = topMenu.outerHeight()+15,
    // All list items
    menuItems = topMenu.find("a"),
    // Anchors corresponding to menu items
    scrollItems = menuItems.map(function(){
      var item = $($(this).attr("href"));
      if (item.length) { return item; }
    });

// Bind click handler to menu items
// so we can get a fancy scroll animation
menuItems.click(function(e){
  var href = $(this).attr("href"),
      offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
   e.preventDefault();
   var target = this.hash;
	    var $target = $(target)
   $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 800, 'swing');
  e.preventDefault();
});

// Bind to scroll
$(window).scroll(function(){
   // Get container scroll position
   var fromTop = $(this).scrollTop()+topMenuHeight;
   
   // Get id of current scroll item
   var cur = scrollItems.map(function(){
     if ($(this).offset().top < fromTop)
       return this;
   });
   // Get the id of the current element
   cur = cur[cur.length-1];
   var id = cur && cur.length ? cur[0].id : "";
   
   if (lastId !== id) {
       lastId = id;
       // Set/remove active class
       menuItems
         .parent().removeClass("active")
         .end().filter("[href=#"+id+"]").parent().addClass("active");
   }                   
});
</script>

<?php
	include ("html/End.php");
?>
