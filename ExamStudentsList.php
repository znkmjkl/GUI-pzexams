<?php
	ob_start();
	
	include_once("lib/Lib.php");
	$title = "$appName - List studentów";
	$scripts = array("js/StudentListEdit.js", "js/Lib/bootbox.min.js", "js/Lib/spin.min.js", "js/Lib/ladda.min.js");
	include("html/Begin.php");
	
	if (!isset($_SESSION['USER']) || $_SESSION['USER'] == "") {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla zalogowanych użytkowników.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	include("html/UserPanel.php");
	$id   = $_GET['examID'];
	$exam = ExamDatabase::getExam($id);
	
	echo "<h2>Lista studentów</h2>";
	echo "<h4><i>(" . $exam->getName() . ")</i></h4>";
	echo "<p>W tym miejscu znajduje się lista wszystkich studentów przypisanych do tego egzaminu. Przy pomocy przycisku możesz dodawać studentów do listy.</p>";
	echo "<hr />";
?>

<div id="buttons">
	<span>
		<button type="button" class="btn btn-primary btn-sm" id="display_modal" data-toggle="modal" data-target="#student_list_modal" style="font-weight: bold;"><i class="glyphicon glyphicon-plus" style="margin-right: 5px;"></i>Dodaj studentów</button>
		<button type="button" class="btn btn-warning btn-sm" id="sendEmails" style="min-width: 16%; font-weight: bold;"><i class="glyphicon glyphicon-send" style="margin-right: 5px;"></i>Wyślij email do wszystkich</button>
		<a class="btn btn-primary btn-sm pull-right" style="font-weight: bold;" href="controler/PDFExamStudentsList.php?examID=<?php echo $exam->getID(); ?>" role="button" name="examStudentsListPDFGlyph" id="examStudentsListPDFGlyph" title="Pobierz PDF" value=<?php echo "\"".$exam->getID()."\""; ?>\><i class="glyphicon glyphicon-download" style="margin-right: 5px;"></i>PDF</a>
	</span>
</div>


<!-- Modal - dodawanie listy studentów -->
<div class="modal fade" id="student_list_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Dodawanie studentów</h4>
      </div>
      <div class="modal-body" style="padding: 20px; padding-bottom: 8px;">
      	<p style="margin-top: 5px; text-align: justify;">
		Umieść w poniższym polu listę studentów, którzy mogą przystąpić do egzaminu. Poszczególne adresy oddzielaj określonym w formacie separatorem.
		Przed każdym z nich możesz opcjonalnie umieścić imię i nazwisko studenta.
		</p>
		<p style="text-align: justify;">
		Jeśli w Twojej liście adresy e-mail znajdują się między jakimiś 
		znakami specjalnymi, określ je w formacie. Natomiast podanie tych znaków w liście nie jest obowiązkowe (nawet jeśli są uwzględnione w formacie).
		</p>
        <div id="student_input" class="container col-md-12 col-sm-12" style="padding-left: 0px; padding-right: 0px; padding-top: 0px;">
			<label id="format_label" for="student_list" class="col-sm-12 control-label" style="margin-top: 20px; padding-left: 0px;">Format: <span id="char1">&lt;</span>adres e-mail<span id="char2">&gt;</span><span id="separator">,</span>
				<a id="changeChars" style="cursor: pointer; margin-left: 8px;">Zmień</a>
			</label>
			<textarea class="form-control" rows="6" id="student_list" style="resize: vertical"></textarea>
		</div>
      </div>

      <div class="modal-footer" style="padding-top: 12px; padding-bottom: 12px; margin-top: 10px;">
        <button id="close_modal" type="button" class="btn btn-default btn-sm" data-dismiss="modal">Zamknij</button>
        <button id="add_students" class="btn btn-primary btn-sm ladda-button" data-style="expand-right" data-spinner-size="30px" style="padding-left: 25px; padding-right: 25px;"><span class="ladda-label">Dodaj</span></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal - end -->

<div style="margin-top: 5%;">
	
<?php
	$studentIDList = RecordDatabase::getStudentIDList($id);
	$studentList = null;
	$displayTable = "";
	$displayInfo = '"';
	
	if (is_array($studentIDList)) {
		$i = 0;
		foreach ($studentIDList as $studentID) {
			$studentList[$i++] = StudentDatabase::getStudentByID($studentID);
		}
	}

	if (!is_array($studentIDList)) {
		$displayTable = ' style="display: none;"';
	} else {
		$displayInfo = ' display: none;"';
	}

		echo '<h3 id="empty_list" style="text-align: center; margin-bottom: 4%;' . $displayInfo . '>Lista studentów jest obecnie pusta</h3>
		<table class="table" id="students"' . $displayTable . '>
		<thead>
			<tr>
				<th style="text-align: center;">Lp.</th>
				<th style="width: 24%;">Imię</th>
				<th style="width: 24%;">Nazwisko</th>
				<th>E-mail</th>
				<th style="text-align: center;">Wysłano</th>
				<th style="text-align:center; width: 5%;">Operacje</th>
				<th style="width: 7%; text-align: center;"></th>
			</tr>
		</thead>
		<tbody>';

		if (is_array($studentIDList)) {

		foreach ($studentList as $number => $student) {
			echo '<tr class="student" id="' . $student->getID() . '">';
			echo '<td id="number" style="text-align: center;">' . ($number+1) .  '.</td>';

			$fName = "-";
			$lName = "-";

			if ($student->getFirstName() != "") {
				$fName = $student->getFirstName();
			}

			if ($student->getSurname() != "") {
				$lName = $student->getSurname();
			}

			echo '<td id="firstname">' . $fName . '</td>';
			echo '<td id="lastname">' . $lName . '</td>';
			echo '<td id="emails">' . $student->getEmail() . '</td>';

			
			$record_id = RecordDatabase::getRecordID($id, $student->getID());
			$record = RecordDatabase::getRecord($record_id);
			$issent_info = "<b style=\"color: #801313;\">Nie</b>";

			if ($record->getIsSent() == 1) {
				$issent_info = "<b style=\"color: #156815;\">Tak</b>";
			}


			echo '<td id="is_sent" style="text-align: center;">' . $issent_info . '</td>';
			echo '<td style="text-align: center;">';
			
			echo '<a id="remove" title="Usuń studenta" style="cursor: pointer; margin-right: 12px;"><i class="glyphicon glyphicon-trash"></i></a>';
			echo '<a id="send" title="Wyślij wiadomość z kodem dostępu do studenta" style="cursor: pointer;"><i class="glyphicon glyphicon-envelope"></i></a>';
			echo '</td><td id="comment" style="padding-left: 10px; padding-right: 0px; padding-top: 6px;"></td>';
			echo '</tr>';
		}
	}

?>
		</tbody>
	</table>
</div>

<?php
	include("html/End.php");
	
	ob_end_flush();
?> 
