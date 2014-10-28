<div id="stage2" style="padding-left: 20px; padding-right: 20px;">
	<h2>Lista studentów</h2>
		<p style="margin-top: 22px; text-align: justify;">
		Umieść w poniższym polu listę studentów, którzy mogą przystąpić do egzaminu. Poszczególne adresy oddzielaj określonym w formacie separatorem.
		Przed każdym z nich możesz opcjonalnie umieścić imię i nazwisko studenta.
		</p>
		<p style="text-align: justify;">
		Jeśli w Twojej liście adresy e-mail znajdują się między jakimiś 
		znakami specjalnymi, określ je w formacie. Natomiast podanie tych znaków w liście nie jest obowiązkowe (nawet jeśli są uwzględnione w formacie).
		</p>
			<label id="format_label" for="student_list" class="col-sm-12 control-label" style="margin-top: 20px; padding-left: 0px;">Format: <span id="char1">&lt;</span>adres e-mail<span id="char2">&gt;</span><span id="separator">,</span>
				<a id="changeChars" style="cursor: pointer; margin-left: 8px;">Zmień</a>
			</label>
			<div class="container col-md-12 col-sm-12" style="padding-left: 0px; padding-right: 0px; padding-top: 0px;">
	
			<div id="student_input" class="container col-md-12 col-sm-12" style="padding-left: 0px; padding-right: 0px; padding-top: 0px;">
			<textarea class="form-control" rows="6" id="student_list" style="resize: vertical"></textarea>
			<span class="pull-right">
				<button type="button" class="btn btn-primary btn-sm" id="add_students" style="margin-top: 10px; padding-left: 25px; padding-right: 25px;">Dodaj</button>
			</span>
		</div>

		<div class="container col-md-6 col-sm-6" id="student_data" style="padding-right: 0px;"></div>

		</div>

		<div class="container col-md-12" style="margin-top: 20px; padding-left: 0px; padding-right: 0px;">
		<h3 id="empty_list" style="text-align: center; margin-bottom: 4%;">Lista studentów jest obecnie pusta</h3>
		<table class="table" id="st" style="display: none;">
			<thead>
				<tr>
					<th style="text-align: center; width: 5%;">Lp.</th>
					<th style="width: 28%;">Imię</th>
					<th style="width: 28%;">Nazwisko</th>
					<th>E-mail</th>
					<th style="text-align:center; width: 5%;">Operacje</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>

		<hr/>

		<span class="pull-left">
			<button type="button" class="btn btn-primary" id="prev2" style="padding-left: 30px; padding-right: 30px;">Cofnij</button>
		</span>
		
		<span class="pull-right" id="confirm">

			<button id="confirm" class="btn btn-success ladda-button" data-style="expand-right"><span class="ladda-label">Potwierdź</span></button>

		</span>
	</div>
</div>
