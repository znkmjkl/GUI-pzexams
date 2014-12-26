<div class="modal fade modal-sm" id="exchangeModal" name="signOutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelSO" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center" id="myModalLabelSO"><b><span id="innerExamName">
					Programowanie rozproszone i równoległe
				</span></b></h3>
			</div>
				<div class="modal-body" id="examExchangeBody">

						<button onclick='loadExamUnitList()' id='examDayButton' class='btn btn-block btn-primary btn-lg'>2015-12-15 (Poniedziałek)</button>

						<table id='examUnitTable' class='table table-condensed table-bordered table-hover'>
							<thead>
								<tr>
									<th>Godziny</th>
									<th>Student</th>
									<th class='col-md-3'>Oferty zamiany</th>
								</tr>
							</thead>
							<tbody>
								<tr class='record1'><td>9.45-10.00</td><td class='studentName'>Jan Nowak</td>
									<td class='oferts'>
										<span class="divPop">
											<span name="test" class='ofertNr'>1</span>
											<button title='Zgłoś chęć wymiany' class='btn btn-sm btn-success glyphicon glyphicon-plus' style='display: none;'></button>
											<ul class="list" style='display: none;'>
												<li class='record4'>10.30-10.45</li>
											</ul>
										</span>
									</td>
								</tr>

								<tr class='record2 me' style='font-weight: bold;'><td>10.00-10.15</td><td class='studentName'>Kamil Malinowski</td>
									<td class='oferts'>
										<span class="divPop exchangePopup">
											<span name="test" class="popupLink ofertNr">2</span>
											<button title='Zgłoś chęć wymiany' class='btn btn-sm btn-success glyphicon glyphicon-plus' style='display: none;'></button>
											<ul class="list">
												<li class='record1'>9.45-10.00</li>
												<li class='record4'>10.30-10.45</li>
											</ul>
										</span>

									</td>
								</tr>
								<tr class='record3'><td>10.15-10.30</td><td class='studentName'>Tomasz Krawiec</td><td class='oferts'><span class="divPop"><span name="test" class='ofertNr'>0</span><button title='Zgłoś chęć wymiany' class='btn btn-sm btn-success glyphicon glyphicon-plus' style='display: none;'></button></span></td></tr>
								<tr class='record4'><td>10.30-10.45</td><td class='studentName'>Grażyna Derp</td><td class='oferts'><span class="divPop"><span name="test" class='ofertNr'>0</span><button title='Zgłoś chęć wymiany' class='btn btn-sm btn-success glyphicon glyphicon-plus' style='display: none;'></button></span></td></tr>
							</tbody>

						</table>

				</div>
				<div id="signInFooter" class="modal-footer">

					<button class='btn btn-default' data-dismiss='modal'>Zamknij</button>

				</div>

		</div>
	</div>
</div>