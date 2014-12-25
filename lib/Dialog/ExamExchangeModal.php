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
									<th class='col-md-5'>Godziny</th>
									<th class='col-md-5'>Student</th>
									<th>dw</th>
								</tr>
							</thead>
							<tbody>
								<tr><td>9.45-10.00</td><td>Jan Nowak</td><td>1</td></tr>
								<tr style='font-weight: bold;'><td>10.00-10.15</td><td>Kamil Malinowski</td>
									<td>

										<div class="exchangePopup">
											<a name="test" class="popupLink" readonly="readonly" >3</a>
											<ul class="list">
												<li>9.45-10.00</li>
												<li>10.30-10.45</li>
											</ul>
										</div>

									</td>
								</tr>
								<tr><td>10.15-10.30</td><td>Tomasz Krawiec</td><td>1</td></tr>
								<tr><td>10.30-10.45</td><td>Grażyna Derp</td><td>1</td></tr>
							</tbody>

						</table>	


						<ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >
						    <li><a tabindex="-1" href="#">9.45-10.00</a></li>
						    <li><a tabindex="-1" href="#">10.30-10.45</a></li>
						</ul>

				</div>
				<div id="signInFooter" class="modal-footer">

					<button class='btn btn-default' data-dismiss='modal'>Zamknij</button>

				</div>

		</div>
	</div>
</div>