//Plik JS obsługuje frontendową część API
var rssApp = angular.module('rssApp', []);

rssApp.controller('EntryController', function($scope, $http, $sce) {
    var entry = this;
    entry.list = [];
    entry.url = 'http://php.net/feed.atom';
    entry.focus = null;
    entry.refresh = function () {
        utils.startWaiting();
        rssAPI.all($http).then(
            function(response) {
                entry.list = response.data;
                utils.stopWaiting();
            },
            function() {
                alert('Coś poszło nie tak.');
                utils.stopWaiting();
            }
        );
    };

    entry.refresh();

    entry.renderHtml = function(htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    };

    entry.updateFromOnline = function(url) {
        if (!utils.validateUrl(url)) {
            return;
        }

        utils.startWaiting();

        rssAPI.updateFromOnline($http, url).then(
            function(response) {
                if (response.data.error) {
                    alert(response.data.error);
                } else {
                    entry.refresh();
                }
            },
            function() {
                alert('Coś poszło nie tak.');
                utils.stopWaiting()
            }
        );
    };

    entry.del = function(id) {
        rssAPI.destroy($http, id).then(
            function() {
                var el = $('div').find('[data-id='+id+']');
                el.html('<div class="alert alert-success">Usunięto rekord!</div>');
                setTimeout(function() {
                    el.remove();
                }, 1500)
            },
            function() {
                alert('Coś poszło nie tak');
            }
        );
    };

    entry.update = function(newEntry) {
        rssAPI.update($http, newEntry).then(
            function(response) {
                entry.refresh();
            },
            function(response) {
                alert('Coś poszło nie tak');
            }
        );
    };
    entry.create = function(newEntry) {
        rssAPI.create($http, newEntry).then(
            function(response) {
                console.log(response);
                entry.refresh();
            },
            function(response) {
                alert('Coś poszło nie tak');
            }
        )
    }
});

var rssAPI = {
    all: function($http) {
        return $http({
            url: 'rss-entry/all',
            method: 'GET'
        });
    },
    updateFromOnline: function($http, feedUrl) {
        return $http({
            url: 'rss-entry/update-from-online',
            method: 'GET',
            params: {url: feedUrl}
        });
    },
    destroy: function($http, id) {
        return $http({
            url: 'rss-entry/destroy/'+id,
            method: 'DELETE'
        });
    },
    update: function($http, entry) {
        return $http({
            url: 'rss-entry/update/'+entry.id,
            method: 'PATCH',
            params: {
                title: entry.title,
                content: entry.content
            }
        });
    },
    create: function($http, entry) {
        return $http({
            url: 'rss-entry/create',
            method: 'POST',
            params: {
                title: entry.title,
                content: entry.content
            }
        })
    }
};