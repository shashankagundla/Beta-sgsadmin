$.getJSON("https://bootswatch.com/api/3.json", function (data) {
    var themes = data.themes;
    var select = $("select");
    var theme = themes[10];
    $("link").attr("href", theme.css);
}, "json").fail(function(){
    $(".alert").toggleClass("alert-info alert-danger");
    $(".alert h4").text("Failure!");
});