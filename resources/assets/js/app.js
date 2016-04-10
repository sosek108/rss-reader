$(document).ready(function() {


    //sprawdzanie poprawnosci url wpisanego w pole. timeout zabezpiecza przed zbyt czestym wywolaniem (czeka az uzytkownik skonczy pisac)
    var timeout = 0;
    $("#feed-url-input").keyup(function() {
        inputField = this;
        if (timeout != 0)
            window.clearTimeout(timeout);

        timeout = setTimeout(function(){
            if (utils.validateUrl(inputField.value) == false) {
                $('.form-group').addClass('has-error');
            }
            else {
                $('.form-group').removeClass('has-error');
            }
        }, 500)
    });
});