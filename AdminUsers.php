<?php
	ob_start();
	
	include_once("lib/Lib.php");
	$title = "$appName - List studentów";
	$scripts = array("js/Lib/bootbox.min.js", "js/Lib/spin.min.js", "js/Lib/ladda.min.js", "js/UserList.js");
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
	
	echo "<h2>Lista użytkowników</h2>";
	echo "<p>W tym miejscu znajduje się lista wszystkich użytkowników.</p>";
	echo "<hr />";

	$userList = UserDatabase::getAllUsers();

	if (!is_array($userList)) {
		$displayTable = ' style="display: none;"';
	} else {
		$displayInfo = ' display: none;"';
	}

	//echo '<pre>'; print_r($userList); echo '</pre>';

	echo '<div style="margin-top: 5%;"><h3 id="empty_list" style="text-align: center; margin-bottom: 4%;' . $displayInfo . '>Lista studentów jest obecnie pusta</h3>
		<table class="table" id="students"' . $displayTable . '>
		<thead>
			<tr>
				<th style="text-align: center;">Lp.</th>
				<th>Imię</th>
				<th>Nazwisko</th>
				<th>E-mail</th>
				<th>Ranga</th>
				<th style="text-align: center;">Operacje</th>
			</tr>
		</thead>
		<tbody>';

	if (is_array($userList)) {
		foreach ($userList as $number => $user) {
			echo '<tr id=row-id-' . $user->getID() . '>';
			echo '<td id="row-lp-'. ($number+1) . '" style="text-align: center;">' . ($number+1) .  '.</td>';
			
			$fName = "-";
			$lName = "-";

			if ($user->getFirstName() != "") {
				$fName = $user->getFirstName();
			}

			if ($user->getSurname() != "") {
				$lName = $user->getSurname();
			}

			echo '<td id="firstname">' . $fName . '</td>';
			echo '<td id="lastname">' . $lName . '</td>';
			echo '<td id="row-email-id-' . $user->getID()  . '">' . $user->getEmail() . '</td>';
			echo '<td id="rank">';
			if($user->getRight() == "examiner"){
				echo "<span style =\"color:rgb(42, 0, 138)\"> Egzaminator </span>";
			}else{
				echo "<span style =\"color:rgb(198, 42, 0)\"> Administrator </span>";;
			} 
			echo '</td>';
			$id = $user->getID();
			echo "<td id=\"data\" style=\"text-align: center;\"><a href=\"AdminUserEdit.php?UserToEdit=" . $id . "\" title=\"Edytuj Użytkownika\"><i class=\"glyphicon glyphicon-pencil\" style=\"margin-right: 10px;\" data-toggle=\"tooltip\" data-placement=\"top\" ></i></a>";
				if($user->getRight()=="administrator" && $user1->getRight()!="owner"){
						echo "<a class=\"disabled\" id=\"row-delete-id-" . $id . "\" style=\"cursor: pointer;\" title=\"Usuń użytkownika\"><i class=\"glyphicon glyphicon-trash\" ></i></a></td>";
				}else{
					if($user1->getRight()==="owner"){
						echo "<a href=\"controler/ChangeRank.php?UserToRank=" . $id . "\" title=\"Zmień rangę\"><i class=\"glyphicon glyphicon-star\" style=\"margin-right: 10px;\" ></i></a>";
					}
					echo "<a id=\"row-delete-id-" . $id . "\" style=\"cursor: pointer;\" title=\"Usuń użytkownika\"><i class=\"glyphicon glyphicon-trash\" ></i></a></td>";
				}
			echo '</tr>';
		}
	}

	echo '</tbody></table></div>';

	include("html/End.php");
	
	ob_end_flush();
?> 