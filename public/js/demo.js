(function () {
    "use strict"
    $('.demo').click(function () {
        var href = this.getAttribute("href");
        var baseurl = $(location).attr("href");
        var cutUrl = RegExp('/[a-z]+$');

        $("#demo").fadeOut("slow", function () {
            $("#demo-output > code").load(href);
            $("#demo-url > a").empty();
            $("#demo-url > a").append("<i>" + baseurl.replace(cutUrl, '/') + href + "</i>").attr("href", href);
        });
        $("#demo").fadeIn("slow");
        return false;
    });
})();