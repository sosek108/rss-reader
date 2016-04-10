//Funkcje pomocnicze
var utils = {
    validateUrl: function(url) {
        var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        var regex = new RegExp(expression);
        return regex.test(url);
    },
    startWaiting: function() {
        var button = $('#feed-url-button');
        button.children('span').text('Czekaj...');
        button.children('i').removeClass('fa-search').addClass('fa-spinner fa-spin');
    },
    stopWaiting: function() {
        var button = $('#feed-url-button');
        button.children('span').text('Aktualizuj');
        button.children('i').removeClass('fa-spinner fa-spin').addClass('fa-search');
    }

};
