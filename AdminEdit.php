<?php

	ob_start();
	
	include_once("lib/Lib.php");
	$title = "$appName - List studentów";
	$scripts = array("js/Lib/bootbox.min.js", "js/Lib/spin.min.js", "js/Lib/ladda.min.js", "js/AdminEdit.js");
	include("html/Begin.php");
	
	if (!isset($_SESSION['USER']) || $_SESSION['USER'] == "") {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla zalogowanych użytkowników.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
	
		ob_end_flush();
		return;
	}

	$user1 = unserialize($_SESSION['USER']);
	
	if ($user1->getRight()!="administrator" && $user1->getRight()!="owner") {
		echo "<div class=\"alert alert-danger\"><b>Brak uprawnień</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	include("html/AdminPanel.php");

	$xml=simplexml_load_file("cfg/Settings.xml");

	echo "<h2>Edycja ustawień portalu</h2>";
	echo "<p>W tym miejscu można edytować ustawienia portalu.</p>";
	echo "<hr>";

	echo '<form class="form-horizontal" role="form" id="admin_form" method="post" action="controler/HandlingSettingsEdit.php">
	<fieldset class="col-xs-12	col-sm-12	col-md-12">';

	echo '<h4>Debug Mode</h4>';
?>
	<div class="form-group">
		<label for="<?php echo strtolower($xml->Debug->getName());?>" class="col-xs-1	col-sm-1	col-md-1	control-label"><?php echo $xml->Debug->getName(); ?></label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="checkbox" class="form-control" id="<?php echo strtolower($xml->Debug->getName());?>" name="<?php echo strtolower($xml->Debug->getName());?>" <?php if($xml->Debug == 1){echo 'checked=checked';}else{echo "";}?>>
		</div>
	</div><br>
<?php
	echo '<hr>';

	echo '<h4>Dostępne Domeny</h4>';
	echo '
	<p>
		<label>Dodaj Domenę
			<input type="text" id="add_domain" />
		</label>
		<a class="btn btn-default" id="add" href="#" role="button">Dodaj</a>
	</p> 
		<ul id="domainsList">';
	foreach( $xml->Domains->children() as $child) {
		$listitem_html = '<li>'.$child.'<input type="hidden" name="domains[]" value="' . $child . '" /> '.'<a href="#" class="remove_domain">Usuń</a>'.'</li>';
		echo $listitem_html;
	}
	echo '</ul>
	';
	echo '<hr>';

	echo '<h4>Ustawienia E-mail</h4><br>';
?>
	<div class="form-group">
		<label for="<?php echo strtolower($xml->Email->Adress->getName());?>" class="col-xs-1	col-sm-1	col-md-1	control-label"><?php echo $xml->Email->Adress->getName(); ?></label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="text" class="form-control" id="<?php echo strtolower($xml->Email->Adress->getName());?>" name="<?php echo strtolower($xml->Email->Adress->getName());?>" value="<?php echo $xml->Email->Adress; ?>">
		</div>
	</div><br>
	<div class="form-group">
		<label for="<?php echo strtolower($xml->Email->Password->getName());?>" class="col-xs-1	col-sm-1	col-md-1	control-label"><?php echo $xml->Email->Password->getName(); ?></label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="password" class="form-control" id="<?php echo strtolower($xml->Email->Password->getName());?>" name="<?php echo strtolower($xml->Email->Password->getName());?>" value="<?php echo $xml->Email->Password; ?>">
				<input id="pass2" type="checkbox" />Pokaż hasło
		</div>
	</div><br>
	<div class="form-group">
		<label for="<?php echo strtolower($xml->Email->Host->getName());?>" class="col-xs-1	col-sm-1	col-md-1	control-label"><?php echo $xml->Email->Host->getName(); ?></label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="text" class="form-control" id="<?php echo strtolower($xml->Email->Host->getName());?>" name="<?php echo strtolower($xml->Email->Host->getName());?>" value="<?php echo $xml->Email->Host; ?>">
		</div>
	</div><br>
	<div class="form-group">
		<label for="<?php echo strtolower($xml->Email->Port->getName());?>" class="col-xs-1	col-sm-1	col-md-1	control-label"><?php echo $xml->Email->Port->getName(); ?></label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="text" class="form-control" id="<?php echo strtolower($xml->Email->Port->getName());?>" name="<?php echo strtolower($xml->Email->Port->getName());?>" value="<?php echo $xml->Email->Port; ?>">
		</div>
	</div><br>
<?php
	echo '<hr>';

	echo '<h4>Ustawienia Autoryzacji</h4><br>';
?>
	<div class="form-group">
		<label for="<?php echo strtolower($xml->Authorization->UseCode->getName());?>" class="col-xs-1	col-sm-1	col-md-1	control-label"><?php echo $xml->Authorization->UseCode->getName(); ?></label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="checkbox" class="form-control" id="<?php echo strtolower($xml->Authorization->UseCode->getName());?>" name="<?php echo strtolower($xml->Authorization->UseCode->getName());?>" <?php if($xml->Authorization->UseCode == 1){echo 'checked=checked';}else{echo "";}?>>
		</div>
	</div><br>
	<div class="form-group">
		<label for="<?php echo strtolower($xml->Authorization->Code->getName());?>" class="col-xs-1	col-sm-1	col-md-1	control-label"><?php echo $xml->Authorization->Code->getName(); ?></label>
			<div class="col-xs-4	col-sm-4	col-md-4">
				<input type="password" class="form-control" id="<?php echo strtolower($xml->Authorization->Code->getName());?>" name="<?php echo strtolower($xml->Authorization->Code->getName());?>" value="<?php echo $xml->Authorization->Code; ?>">
				<input id="code2" type="checkbox" />Pokaż hasło
		</div>
	</div><br>
<?php
	echo '<hr>';
?>
<div class="form-group">
			<span class="col-xs-3 col-sm-3	col-md-3">
				<button type="submit" class="btn btn-primary" name="submitButton" value="submit">Zapisz ustawienia</button>
			</span>
		</div>
	</fieldset>
</form>
<?php
	//echo '<pre>';
	//print_r($xml);
	//echo '</pre>';

	include("html/End.php");
	
	ob_end_flush();
?>