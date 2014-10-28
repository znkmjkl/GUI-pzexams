$(document).ready(function() {
	$('.carousel').carousel({
		interval: 7000
	});
	//$('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
	$('[tooltip-placement="top"]').tooltip({'placement': 'top'});
	$('[tooltip-placement="left"]').tooltip({'placement': 'left'});
	$('[tooltip-placement="right"]').tooltip({'placement': 'right'});
});
