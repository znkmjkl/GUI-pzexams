				</div>
			</div>

			<div id="footer" class="container col-sm-12 col-md-12 col-lg-12">
				<p class="pull-left" style="letter-spacing:1px">PZ-Exams 2014. Wszystkie prawa zastrzeżone ©</p>
				<span class="pull-right" style="margin-top: 1px; margin-left: 80px;">
					
					<?php	if(isset($_SESSION['USER'])	&&	$_SESSION['USER']	!=	""){?>
						<span><a id="contact" href="Contact.php">Kontakt</a></span>					
						<span>| <a id="help" href="Help.php">Pomoc</a></span>			
					<?php } ?>
				</span>
			</div>
		</div>
		
		<script language="javascript" type="text/javascript" src="js/Lib/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/global.js" charset="UTF-8"></script>
	</body>
</html>