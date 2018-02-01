(function() {
	"use strict"
	$('.demo').click(function () {
		var href = this.getAttribute("href");
		$("#demo").fadeOut("slow", function () {
			$("#demo-output > code").load(href);
		});
		$("#demo").fadeIn("slow");
		return false;
	});
})();