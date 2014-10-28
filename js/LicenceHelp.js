$(document).ready(function () {
	$(".panel-heading").click(function () {
		var elementID = $(this).attr("id");
		if (elementID != null) {
			$("#b" + elementID).slideToggle();
			$("#g" + elementID).slideToggle();
		}
	});
});