$(".alert").hide();
$("form").submit(function() {
    $(".alert").hide();
    var email = $("#inputEmail").val();
    var pass = $("#inputPassword").val();
    $.post(".", {action: "login", email: email, pass: pass}, function(data){
        if (data.result == 'ok') {
            $("#name").text(data.name);
            $("form").slideUp();
            $("#success").slideDown();
        } else {
            $("#error").slideDown();
        }
    }, 'json');
    return false;
});